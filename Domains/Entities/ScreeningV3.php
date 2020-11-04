<?php


class ScreeningV3
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
        $screening = new ScreeningV3();

        $screening->applicant_email_address = $applicant_email_address;

        $screening->screening_id = new ScreeningId();
        $screening->interviews = new Interviews();

        $screening->status = new ScreeningStatusV3( ScreeningStatusV3::NOTAPPLIED );
        $screening->apply_date = null;

        return $screening;
    }

    public function apply( EmailAddress $applicant_email_address )
    {
        $screening = new ScreeningV3();

        $screening->applicant_email_address = $applicant_email_address;

        $screening->screening_id = new ScreeningId();
        $screening->interviews = new Interviews();

        $screening->status = new ScreeningStatusV3( 'Interview' );
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

    public function reconstruct( ScreeningId $screening_id, DateTime $apply_date, ScreeningStatusV3 $screening_status, EmailAddress $applicant_email_address, Interviews $interviews )
    {
        $screening = new ScreeningV3();
        $screening->screening_id = $screening_id;
        $screening->apply_date = $apply_date;
        $screening->status = $screening_status;
        $screening->applicant_email_address = $applicant_email_address;
        $screening->interviews = $interviews;

        return $screening;
    }

    /**
     * @param mixed $status_name
     */
    public function setStatus( $status_name )
    {
        $this->status = new ScreeningStatusV3( $status_name );
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
}