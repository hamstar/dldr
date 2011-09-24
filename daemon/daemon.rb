
require "uri"
require "net/http"
require "json"

api_url = "http://hax.420truth.com/api.rhtml";
run_daemon = true

until run_daemon == false

  # get running download from db
  download = Download.running
  
  # no download currently running? continue
  if download
    while !download.finished
    
      params = {
        "action" => "status",
        "url" => download.url
      }
      
      x = Net::HTTP.post_form( api_url, params );
      
      json = JSON.parse x.body
      
      download.update( json )
      sleep(10.seconds)
    end
  end
  
  # get new url to download
  download = Download.new( URL.new )

  params = {
    "action" => "download",
    "url" => download.url
  }
  
  x = Net::HTTP.post_form( api_url, params );

  json = JSON.parse x.body
  download.update( json )

end
