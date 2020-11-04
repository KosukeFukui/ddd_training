<?php


class ScreeningApplicationServiceV3
{
    private $repo;
    private $screening;

    private $permitted_statuses;

    public function __construct()
    {
        $this->repo = new ScreeningDbRepositoryV3();
        $this->screening = new ScreeningV3();

        $this->permitted_statuses = [
            //before_status => [ after_statuses ]
            ScreeningStatusName::NOTAPPLIED => [ ScreeningStatusName::DOCUMENTSCREENING ],
            ScreeningStatusName::DOCUMENTSCREENING => [ ScreeningStatusName::DOCUMENTSCREENINGREJECTED, ScreeningStatusName::DOCUMENTSCREENINGDECLINED, ScreeningStatusName::INTERVIEW ],
            ScreeningStatusName::INTERVIEW => [ ScreeningStatusName::INTERVIEWREJECTED, ScreeningStatusName::INTERVIEWDECLINED, ScreeningStatusName::OFFERED ],
            ScreeningStatusName::OFFERED => [ ScreeningStatusName::OFFERDECLINED, ScreeningStatusName::ENTERED ],
        ];
    }

    public function startFromPreInterview( EmailAddress $applicant_email_address )
    {
        $screening = $this->screening->startFromPreInterview( $applicant_email_address );
        $this->repo->insert( $screening );
    }

    public function apply( EmailAddress $applicant_email_address )
    {
        $screening = $this->screening->apply( $applicant_email_address );
        $this->repo->insert( $screening );
    }

    public function addNextInterview( ScreeningId $screening_id, DateTime $interview_date )
    {
        $screening = $this->repo->findById( $screening_id );
        $screening->addNextInterview( $interview_date );
        $this->repo->update( $screening );
    }

    public function updateStatus( ScreeningId $screening_id, $screening_status_name )
    {
        $screening = $this->repo->findById( $screening_id );

        if ( !$this->isPermittedStatus( $screening->getStatus()->name, $screening_status_name ) ) {
            echo '不正な操作です';
        } else {
            $screening->setStatus( $screening_status_name );
            $this->repo->update( $screening );
        }
    }

    private function isPermittedStatus( $before_status_name, $after_status_name )
    {
        return in_array( $after_status_name, $this->permitted_statuses[ $before_status_name ] );
    }
}