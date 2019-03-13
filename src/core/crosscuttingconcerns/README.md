


<b>Using The Logger class in Logger.php</b> "/core/crosscuttingconcers/log/Logger.php"

<pre><code>
give a ILogger  in Logger class
$ad = new Logger(new FileLogger());
$ad->Log("hello",FileLogger::WARNING) ;
$ad->Log("hello",FileLogger::ERROR) ;
$ad->Log("hello",FileLogger::NOTICE) ;
$ad->Log("hello",FileLogger::FATAL) ;

// Example; new Logger(new APILogger())

class APILogger implement ILogger{
        public function Log($message,$type){};
}

</pre></code>

- We are adding language files like shortcode.json. "/res/values/language/"

