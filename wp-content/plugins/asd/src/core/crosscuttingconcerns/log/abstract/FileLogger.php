<?php

namespace log;

require_once('ILogger.php');

use Exception;


    class FileLoggerException extends Exception {}
    
    /**
     * File logger
     * 
     * Log notices, warnings, errors or fatal errors into a log file.
     * 
     * @author gehaxelt
     */
    class FileLogger implements ILogger {
        
        /**
         * Holds the file handle.
         * 
         * @var resource
         */
        protected $fileHandle = NULL;
        
        /**
         * The time format to show in the log.
         * 
         * @var string
         */
        protected $timeFormat = 'd.m.Y - H:i:s';
        
        /**
         * The file permissions.
         */

        private $logfile;
        const FILE_CHMOD = 756;
        
        const NOTICE = '[NOTICE]';
        const WARNING = '[WARNING]';
        const ERROR = '[ERROR]';
        const FATAL = '[FATAL]';
        
        /**
         * Opens the file handle.
         * 
         * @param string $logfile The path to the loggable file.
         */
        public function __construct() {
            $this->logfile = __DIR__ . '/logs/log.php';
        }

        public function setupLogger(){
            if($this->fileHandle == NULL){
                $this->openLogFile();
            }
        }

        public function setLogFile($path){
            $this->logfile = $path;
        }
        
        /**
         * Closes the file handle.
         */
        public function __destruct() {
            $this->closeLogFile();
        }
        
        /**
         * Logs the message into the log file.
         * 
         * @param  string $message     The log message.
         * @param  int    $messageType Optional: urgency of the message.
         */
        public function Log($message, $messageType = FileLogger::WARNING) {

            if($this->fileHandle == NULL){
                throw new FileLoggerException('Logfile is not opened.');
            }
            
            if(!is_string($message)){
                throw new FileLoggerException('$message is not a string');
            }
            
            if($messageType != FileLogger::NOTICE &&
               $messageType != FileLogger::WARNING &&
               $messageType != FileLogger::ERROR &&
               $messageType != FileLogger::FATAL
            ){
                throw new FileLoggerException('Wrong $messagetype given.');
            }
            
            $this->writeToLogFile("[".$this->getTime()."]".$messageType." - ".$message);
        }
        
        /**
         * Writes content to the log file.
         * 
         * @param string $message
         */
        protected function writeToLogFile($message) {
            flock($this->fileHandle, LOCK_EX);
            fwrite($this->fileHandle, $message.PHP_EOL);
            flock($this->fileHandle, LOCK_UN);
        }
        
        /**
         * Returns the current timestamp.
         * 
         * @return string with the current date
         */
        protected function getTime() {
            return date($this->timeFormat);
        }
        
        /**
         * Closes the current log file.
         */
        protected function closeLogFile() {
            if($this->fileHandle != NULL) {
                fclose($this->fileHandle);
                $this->fileHandle = NULL;
            }
        }
        
        /**
         * Opens a file handle.
         * 
         * @param string $logFile Path to log file.
         */
        public function openLogFile() {

            $this->closeLogFile();
            $logFile = $this->logfile;
            if(!is_dir(dirname($logFile))){
                if(!mkdir(dirname($logFile), FileLogger::FILE_CHMOD, true)){
                    throw new FileLoggerException('Could not find or create directory for log file.');
                }
            }

            if(!$this->fileHandle = fopen($logFile, 'a+')){
                throw new FileLoggerException('Could not open file handle.');
            }

        }

        public function opendd(){
            return 'dsd6d';
        }


    
}
