import pandas as pd
import os
import numpy as np

df = pd.read_csv('demodata.csv')
dfnew = df.drop_duplicates(subset='id')

# dfnew.to_csv('demodatawithoutdup.csv')

unique_ids = dfnew['id'].unique()
len(unique_ids)

indir = 'xmldemo/'

for i in unique_ids:
    count = 0
    for fn in os.listdir(indir):
        data = open('xmldemo/' + fn).read()
        count = count + data.count(str(i))
    print(str(i), count)
