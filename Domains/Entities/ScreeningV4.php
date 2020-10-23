<?php


class ScreeningV4
{
    private $screening_id;
    private $apply_date;
    private $status;
    private $applicant_email_address;
    private $interviews;

    public function __construct()
    {
    }

    public function startFromPreInterview( EmailAddress $applicant_email_address )
    {
        $screening = new ScreeningV4();

        $screening->applicant_email_address = $applicant_email_address;

        $screening->screening_id = new ScreeningId();
        $screening->interviews = new Interviews();

        $screening->status = new ScreeningStatusV4( new ScreeningStatusNameV5( ScreeningStatusNameV5::NOTAPPLIED ) );
        $screening->apply_date = null;

        return $screening;
    }

    public function apply( EmailAddress $applicant_email_address )
    {
        $screening = new ScreeningV4();

        $screening->applicant_email_address = $applicant_email_address;

        $screening->screening_id = new ScreeningId();
        $screening->interviews = new Interviews();

        $screening->status = new ScreeningStatusV4( new ScreeningStatusNameV5( ScreeningStatusNameV5::INTERVIEW ) );
        $screening->apply_date = DateTime::__construct( 'now' );

        return $screening;
    }

    public function addNextInterview( DateTime $interview_date )
    {
        if ( !$this->status->canAddInterview() ) {
            print_r( '不正な操作です' );
        } else {
            $this->interviews->addNextInterview( $interview_date );
        }
    }

    public function reconstruct( ScreeningId $screening_id, DateTime $apply_date, ScreeningStatusNameV5 $screening_status, EmailAddress $applicant_email_address, Interviews $interviews )
    {
        $screening = new ScreeningV4();
        $screening->screening_id = $screening_id;
        $screening->apply_date = $apply_date;
        $screening->status = new ScreeningStatusV4( $screening_status );
        $screening->applicant_email_address = $applicant_email_address;
        $screening->interviews = $interviews;

        return $screening;
    }

    public function stepToNext()
    {
        $this->status = $this->status->nextStep();
    }

    public function stepToPrevious()
    {
        $this->status = $this->status->previousStep();
    }

    public function stepToRejected()
    {
        $this->status = $this->status->rejectedStep();
    }

    public function stepToDeclined()
    {
        $this->status = $this->status->declinedStep();
    }
}