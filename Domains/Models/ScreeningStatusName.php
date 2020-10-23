<?php


class ScreeningStatusName extends Enum
{
    /** 未応募 */
    const NOTAPPLIED = 'NotApplied';

    /** 書類選考 */
    const DOCUMENTSCREENING = 'DocumentScreening';
    /** 書類不合格 */
    const DOCUMENTSCREENINGREJECTED = 'DocumentScreeningRejected';
    /** 書類選考辞退 */
    const DOCUMENTSCREENINGDECLINED = 'DocumentScreeningDeclined';

    /** 面接選考中 */
    const INTERVIEW = 'Interview';
    /** 面接不合格 */
    const INTERVIEWREJECTED = 'InterviewRejected';
    /** 面接辞退 */
    const INTERVIEWDECLINED = 'InterviewDeclined';

    /** 内定 */
    const OFFERED = 'Offered';
    /** 内定辞退 */
    const OFFERDECLINED = 'OfferDeclined';

    /** 入社済 */
    const ENTERED = 'Entered';
}