class Dldr

  @run_folder = File.dirname(__FILE__)

  def  initialize(run_folder)
    @run_folder = run_folder
  end

  def download(url, filename)
  
    log_file = @run_folder + filename + ".log"
    out = `wget -b #{url} -O #{filename} -o #{log_file}`
  end

end