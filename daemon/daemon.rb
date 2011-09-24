require "uri"
require "net/http"
require "json"

api_url = "http://example.com/api.rhtml";
run_daemon = true

while run_daemon == true

  # get running download from db
  download = Download.running
  
  # no download currently running? continue
  if download
    while !download.finished
    
      params = {
        "action" => "status",
        "url" => download.url
      }
      
      json = JSON.parse Net::HTTP.post_form( api_url, params ).body;
      
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
  
  json = JSON.parse Net::HTTP.post_form( api_url, params ).body;

  download.status = json.status

end
