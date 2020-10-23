<?php


class ScreeningApplicationServiceV4
{
    private $repo;
    private $screening;

    public function __construct()
    {
        $this->repo = new ScreeningDbRepositoryV4();
        $this->screening = new ScreeningV4();
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

    public function stepToNext( ScreeningId $screening_id )
    {
        $screening = $this->repo->findById( $screening_id );
        $screening->stepToNext();
        $this->repo->update( $screening );
    }

    public function stepToPrevious( ScreeningId $screening_id )
    {
        $screening = $this->repo->findById( $screening_id );
        $screening->stepToPrevious();
        $this->repo->update( $screening );
    }

    public function stepToRejected( ScreeningId $screening_id )
    {
        $screening = $this->repo->findById( $screening_id );
        $screening->stepToRejected();
        $this->repo->update( $screening );
    }

    public function stepToDeclined( ScreeningId $screening_id )
    {
        $screening = $this->repo->findById( $screening_id );
        $screening->stepToDeclined();
        $this->repo->update( $screening );
    }
}