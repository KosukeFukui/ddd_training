<?php


class ScreeningStatusV4
{
    private $canAddInterview;
    private $name;

    public function __construct( ScreeningStatusName $name )
    {
        $this->name = $name;
        $this->setCanAddInterview( $name );
    }

    private function setCanAddInterview( ScreeningStatusName $name )
    {
        switch ( $name ) {
            case ScreeningStatusName::NOTAPPLIED:
            case ScreeningStatusName::DOCUMENTSCREENING:
            case ScreeningStatusName::DOCUMENTSCREENINGREJECTED:
            case ScreeningStatusName::DOCUMENTSCREENINGDECLINED:
            case ScreeningStatusName::INTERVIEWREJECTED:
            case ScreeningStatusName::INTERVIEWDECLINED:
            case ScreeningStatusName::OFFERED:
            case ScreeningStatusName::OFFERDECLINED:
            case ScreeningStatusName::ENTERED:
                $this->canAddInterview = false;
                break;
            case ScreeningStatusName::INTERVIEW:
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
            case ScreeningStatusName::NOTAPPLIED:
                return new ScreeningStatusV4( new ScreeningStatusName( ScreeningStatusName::DOCUMENTSCREENING ) );
            case ScreeningStatusName::DOCUMENTSCREENING:
                return new ScreeningStatusV4( new ScreeningStatusName( ScreeningStatusName::INTERVIEW ) );
            case ScreeningStatusName::INTERVIEW:
                return new ScreeningStatusV4( new ScreeningStatusName( ScreeningStatusName::OFFERED ) );
            case ScreeningStatusName::OFFERED:
                return new ScreeningStatusV4( new ScreeningStatusName( ScreeningStatusName::ENTERED ) );
            default:
                echo '許可されていない状態遷移です';
        }
    }

    public function previousStep()
    {
        switch ( $this ) {
            case ScreeningStatusName::DOCUMENTSCREENINGREJECTED:
            case ScreeningStatusName::DOCUMENTSCREENINGDECLINED:
            case ScreeningStatusName::INTERVIEW:
                return new ScreeningStatusV4( new ScreeningStatusName( ScreeningStatusName::DOCUMENTSCREENING ) );
            case ScreeningStatusName::INTERVIEWREJECTED:
            case ScreeningStatusName::INTERVIEWDECLINED:
            case ScreeningStatusName::OFFERED:
                return new ScreeningStatusV4( new ScreeningStatusName( ScreeningStatusName::INTERVIEW ) );
            case ScreeningStatusName::OFFERDECLINED:
            case ScreeningStatusName::ENTERED:
                return new ScreeningStatusV4( new ScreeningStatusName( ScreeningStatusName::OFFERED ) );
            default:
                echo '許可されていない状態遷移です';
        }
    }

    public function rejectedStep()
    {
        switch ( $this->name ) {
            case ScreeningStatusName::DOCUMENTSCREENING:
                return new ScreeningStatusV4( new ScreeningStatusName( ScreeningStatusName::DOCUMENTSCREENINGREJECTED ) );
            case ScreeningStatusName::INTERVIEW:
                return new ScreeningStatusV4( new ScreeningStatusName( ScreeningStatusName::INTERVIEWREJECTED ) );
            default:
                echo '許可されていない状態遷移です';
        }
    }

    public function declinedStep()
    {
        switch ( $this->name ) {
            case ScreeningStatusName::DOCUMENTSCREENING:
                return new ScreeningStatusV4( new ScreeningStatusName( ScreeningStatusName::DOCUMENTSCREENINGDECLINED ) );
            case ScreeningStatusName::INTERVIEW:
                return new ScreeningStatusV4( new ScreeningStatusName( ScreeningStatusName::INTERVIEWDECLINED ) );
            case ScreeningStatusName::OFFERED:
                return new ScreeningStatusV4( new ScreeningStatusName( ScreeningStatusName::OFFERDECLINED ) );
            default:
                echo '許可されていない状態遷移です';
        }
    }
}