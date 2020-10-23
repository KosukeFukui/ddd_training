<?php


class Interview
{
    private $screening_date;
    private $interview_number;
    private $screening_step_result;

    public function __construct( DateTime $interview_date, $interview_number )
    {
        $this->screening_date = $interview_date;
        $this->interview_number = $interview_number;

        $this->screening_step_result = ScreeningStepResult::NOTEVALUATED;
    }

    public function reconstruct( DateTime $interview_date, $interview_number, ScreeningStepResult $screening_step_result )
    {
        $interview = new Interview( $interview_date, $interview_number );
        $interview->screening_step_result = $screening_step_result;

        return $interview;
    }
}