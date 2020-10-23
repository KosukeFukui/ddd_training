<?php


class ScreeningStatusV3
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
}