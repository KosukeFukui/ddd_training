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
            ScreeningStatusV4::NOTAPPLIED => [ ScreeningStatusV4::DOCUMENTSCREENING ],
            ScreeningStatusV4::DOCUMENTSCREENING => [ ScreeningStatusV4::DOCUMENTSCREENINGREJECTED, ScreeningStatusV4::DOCUMENTSCREENINGDECLINED, ScreeningStatusV4::INTERVIEW ],
            ScreeningStatusV4::INTERVIEW => [ ScreeningStatusV4::INTERVIEWREJECTED, ScreeningStatusV4::INTERVIEWDECLINED, ScreeningStatusV4::OFFERED ],
            ScreeningStatusV4::OFFERED => [ ScreeningStatusV4::OFFERDECLINED, ScreeningStatusV4::ENTERED ],
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

    public function updateStatus( ScreeningId $screening_id, $screening_status )
    {
        $screening = $this->repo->findById( $screening_id );

        if ( !$this->isPermittedStatus( $screening->getStatusName(), $screening_status ) ) {
            echo '不正な操作です';
        } else {
            $screening->setStatus( $screening_status );
            $screening->setStatusName( $screening_status );
            $this->repo->update( $screening );
        }
    }

    private function isPermittedStatus( $before_status, $after_status )
    {
        return in_array( $after_status, $this->permitted_statuses[ $before_status ] );
    }
}