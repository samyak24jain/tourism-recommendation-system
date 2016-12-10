import flickr_api
import urllib2
from flickr_api.api import flickr
import time
import socket

flickr_api.set_keys(api_key = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', api_secret = 'yyyyyyyyyyyyyyyy')
flickr_api.set_auth_handler("AuthToken")

# number of seconds to skip per query  
#timeskip = 62899200 #two years
timeskip = 604800 * 8  #one week
# timeskip = 345600 #four days	
# timeskip = 172800  #two days
#timeskip = 86400 #one day

mintime = 1356998400  
maxtime = mintime+timeskip
endtime = 1478291882

fileno = 0

while (maxtime <= endtime):
	for i in range(1,17):
		while True:
			try:
				photo_list = flickr.photos.search(api_key='xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', has_geo=1, extras='description,license,geo,tags,machine_tags,o_dims,date_taken,date_upload,views,media,path_alias,url_sq,url_t,url_s,url_q,url_m,url_n,url_z,url_c,url_l,url_o', per_page=250, page=i, min_upload_date=str(mintime), max_upload_date=str(maxtime), accuracy=6)
				f = open('xmldata/photodata' + str(fileno) + '.xml','w')
				f.write(photo_list)
				f.close()
				print(str(fileno))
				fileno = fileno + 1
				time.sleep(1)
			except urllib2.URLError:
				continue
			except socket.error:
				continue
			break

	mintime = maxtime
	maxtime = mintime + timeskip
		