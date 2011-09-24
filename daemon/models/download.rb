
class Download
  @url
  @status
  @filename
  
  attr_accessor :status
  attr_reader :url, :filename

  def initialize(url)
    @url = url.url
    @filename = url.filename
  end

  def self.running
    #dbh.do("select * from downloads where running = 1 limit 1") do |row|
    #  @status = row.status
    #  @url = row.url
    #  @filename = row.filename
    #end
  end
  
  def finished
    @status == "finished"
  end

end