<?php


class EmailAddress
{
    private $value;

    public function __construct( $value )
    {
        if ( $this->isEmpty( $value ) || $this->isInvalidFormatEmailAddress( $value ) ) {
            print_r( 'メールアドレスが正しくありません' );
        } else {
            $this->value = $value;
        }
    }

    /**
     * @return bool
     */
    private function isEmpty( $value )
    {
        return $value == null || strlen( $value ) == 0;
    }

    private function isInvalidFormatEmailAddress( $email )
    {
        if ( $email == null ) {
            return false;
        }
        //以下、適切な文字が使用されているという確認
    }

    public function getValue()
    {
        return $this->value;
    }
}