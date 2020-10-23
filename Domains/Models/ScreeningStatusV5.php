<?php


class ScreeningStatusV5
{
    private $canAddInterview;
    private $name;

    public function __construct( ScreeningStatusNameV5 $name )
    {
        $this->name = $name;
        $this->setCanAddInterview( $name );
    }

    private function setCanAddInterview( ScreeningStatusNameV5 $name )
    {
        switch ( $name ) {
            case ScreeningStatusNameV5::NOTAPPLIED:
            case ScreeningStatusNameV5::DOCUMENTSCREENING:
            case ScreeningStatusNameV5::DOCUMENTSCREENINGREJECTED:
            case ScreeningStatusNameV5::DOCUMENTSCREENINGDECLINED:
            case ScreeningStatusNameV5::INTERVIEWREJECTED:
            case ScreeningStatusNameV5::INTERVIEWDECLINED:
            case ScreeningStatusNameV5::PASSED:
            case ScreeningStatusNameV5::OFFERED:
            case ScreeningStatusNameV5::OFFERDECLINED:
            case ScreeningStatusNameV5::ENTERED:
                $this->canAddInterview = false;
                break;
            case ScreeningStatusNameV5::INTERVIEW:
                $this->canAddInterview = true;
                break;
        }
    }

    /**
     * @return mixed
     */
    public function getCanAddInterview()
    {
        return $this->canAddInterview;
    }

    public function nextStep()
    {
        switch ( $this->name ) {
            case ScreeningStatusNameV5::NOTAPPLIED:
                return new self( new ScreeningStatusNameV5( ScreeningStatusNameV5::DOCUMENTSCREENING ) );
            case ScreeningStatusNameV5::DOCUMENTSCREENING:
                return new self( new ScreeningStatusNameV5( ScreeningStatusNameV5::INTERVIEW ) );
            case ScreeningStatusNameV5::INTERVIEW:
                return new self( new ScreeningStatusNameV5( ScreeningStatusNameV5::PASSED ) );
            case ScreeningStatusNameV5::PASSED:
                return new self( new ScreeningStatusNameV5( ScreeningStatusNameV5::OFFERED ) );
            case ScreeningStatusNameV5::OFFERED:
                return new self( new ScreeningStatusNameV5( ScreeningStatusNameV5::ENTERED ) );
            default:
                echo '許可されていない状態遷移です';
        }
    }

    public function previousStep()
    {
        switch ( $this ) {
            case ScreeningStatusNameV5::DOCUMENTSCREENINGREJECTED:
            case ScreeningStatusNameV5::DOCUMENTSCREENINGDECLINED:
            case ScreeningStatusNameV5::INTERVIEW:
                return new self( new ScreeningStatusNameV5( ScreeningStatusNameV5::DOCUMENTSCREENING ) );
            case ScreeningStatusNameV5::INTERVIEWREJECTED:
            case ScreeningStatusNameV5::INTERVIEWDECLINED:
            case ScreeningStatusNameV5::PASSED:
                return new self( new ScreeningStatusNameV5( ScreeningStatusNameV5::INTERVIEW ) );
            case ScreeningStatusNameV5::OFFERED:
                return new self( new ScreeningStatusNameV5( ScreeningStatusNameV5::PASSED ) );
            case ScreeningStatusNameV5::OFFERDECLINED:
            case ScreeningStatusNameV5::ENTERED:
                return new self( new ScreeningStatusNameV5( ScreeningStatusNameV5::OFFERED ) );
            default:
                echo '許可されていない状態遷移です';
        }
    }

    public function rejectedStep()
    {
        switch ( $this->name ) {
            case ScreeningStatusNameV5::DOCUMENTSCREENING:
                return new self( new ScreeningStatusNameV5( ScreeningStatusNameV5::DOCUMENTSCREENINGREJECTED ) );
            case ScreeningStatusNameV5::INTERVIEW:
                return new self( new ScreeningStatusNameV5( ScreeningStatusNameV5::INTERVIEWREJECTED ) );
            default:
                echo '許可されていない状態遷移です';
        }
    }

    public function declinedStep()
    {
        switch ( $this->name ) {
            case ScreeningStatusNameV5::DOCUMENTSCREENING:
                return new self( new ScreeningStatusNameV5( ScreeningStatusNameV5::DOCUMENTSCREENINGDECLINED ) );
            case ScreeningStatusNameV5::INTERVIEW:
                return new self( new ScreeningStatusNameV5( ScreeningStatusNameV5::INTERVIEWDECLINED ) );
            case ScreeningStatusNameV5::OFFERED:
                return new self( new ScreeningStatusNameV5( ScreeningStatusNameV5::OFFERDECLINED ) );
            default:
                echo '許可されていない状態遷移です';
        }
    }
}