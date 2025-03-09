<?php

namespace Chapa\Exception;

use RuntimeException;

/**
 * Runtime exception that is thrown for invalid post data.
 */
class InvalidPostDataException extends RuntimeException{

    // TODO: modify and use stackTrace instead of default method

    /**
     * @return string
     */
    public function stackTrace(){
        return 'Error on line ' . $this->getLine() . '  on ' . $this->getFile()
                . '. ' . $this->getMessage();
    }
}