<?php


class Interviews
{
    private $interviews;

    public function __construct()
    {
        $this->interviews = array();
    }

    private function addNextInterview( DateTime $interview_date )
    {
        array_push( $this->interviews, new Interview( $interview_date, $this->getNextInterviewNumber() ) );
    }

    private function getNextInterviewNumber()
    {
        return count( $this->interviews ) + 1;
    }
}