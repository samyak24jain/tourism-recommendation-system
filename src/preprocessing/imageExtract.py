import os
import pandas as pd
import math
import urllib, threading

df = pd.read_csv('finalwithoutdup.csv')

urls = list(df['url_n'])
ids = list(df['id'])

map_id_to_url = {}

for i in range(len(urls)):
    map_id_to_url[ids[i]] = urls[i]

photoid = []
for fn in os.listdir('images/'):
    photoid.append(int((fn.split('.')[0]).split('_')[1]))

for key in photoid:
    if key in map_id_to_url:
        del map_id_to_url[key]

l =len(map_id_to_url)

a = l/3
b = 2 * a
d1 = dict(map_id_to_url.items()[:a])
# d2 = dict(map_id_to_url.items()[a:b])
# d3 = dict(map_id_to_url.items()[b:])

def fetch_image(url, photoid):
    while True:
        try:
            urllib.urlretrieve(url, "images/photo_" + str(photoid) + ".jpg")
            print(photoid)
        except IOError:
            continue
        break

threads = [threading.Thread(target=fetch_image, args = (d1[photoid], photoid)) for photoid in d1.keys()]
for t in threads:
    t.start()
for t in threads:
    t.join()
