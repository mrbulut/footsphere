<?php

class FopenConnectionAdapter extends AbstractConnectionUrl
{
    public function getUrl($url, $params = array(), $options = false)
    {
        $params = array(
            'http' => array(
                'method'  => 'POST',
                'content' => http_build_query($params)
            )
        );
        
        $ctx = stream_context_create($params);
        
        $fp = @fopen($url, 'rb', false, $ctx);
        
        if (!$fp) {
            throw new EnvatoApiServerNotFound();
        }
        if (!$fp) {
            return false;
        }
        
        $response = @stream_get_contents($fp);
        
        fclose($fp);
        
        if ($this->hasErrorInResponse($response)) {
             throw new EnvatoApiServerNotFound();
        }
        
        return $response;
    } // end getUrl
    
    public function isDomainAvailible($url)
    {
        return (bool) $this->getUrl($url);
    } // end isDomainAvailible
}
