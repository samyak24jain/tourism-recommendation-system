import os
import pandas as pd
import math
import pickle

df = pd.read_csv('finalwithoutdup.csv')

urls = list(df['url_n'])
ids = list(df['id'])

map_id_to_url = {}
for i in range(len(urls)):
    map_id_to_url[ids[i]] = urls[i]
len(map_id_to_url)


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
d2 = dict(map_id_to_url.items()[a:b])
d3 = dict(map_id_to_url.items()[b:])

with open('dict.pickle', 'w') as f:
    pickle.dump([d1,d2,d3], f)