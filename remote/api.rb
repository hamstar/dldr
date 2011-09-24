
class API
  @run_folder
  
  def run_folder=(run_folder)
    if run_folder[run_folder.length] != "/"
      run_folder + "/"
    end
    @run_folder = run_folder
  end
  
  def download( url )
  
    dldr = DLDR.new( @run_folder )
    filename = Digest::MD5.hexdigest( url )
    dldr.get( url, filename )
    
    # probably need exception checking here
    
    {
      "status" => "running"
    }
    
  end
  
  def status( url )
  
    filename = @run_folder + Digest::MD5.hexdigest( url )
    lines = Array.new
    IO.foreach(filename) { |line| 
      lines << line
    }
    
    # Set some default values
    percent = 0
    size = 0
    rate = 0
    time_remaining = 0
    status = "running"
    
    # Find the last line that has a percentage
    lines.reverse.each |line|
      if !line.include? "%"
        next
      end
      
      percent = line.match('(\d)%')[0]
      
      if percent != 100
        status = "finished"
        matches = line.match('(\d+[MKG]).*\d% (.*) (.*)') # extract data
        size = matches[1]
        rate = matches[2]
        time_remaining = matches[3]
      end
      
      break # we don't want anymore lines
    end
    
    # Return a hash of data
    {
      "status" => status
      "percent" => percent,
      "size" => size,
      "rate" => rate,
      "time_remaining" => time_remaining
    }
  end
  
  

end