import xml.etree.ElementTree as ET
import pandas as pd
import numpy as np  
from joblib import Parallel, delayed 
import time

tree = ET.parse('xmldata/photodata1.xml')
root = tree.getroot()
x = root[0][1].attrib.keys()

df = pd.DataFrame(columns=['SNo', 'Description'] + x)


def append_df(i):
    global row, df
    dic = root[0][i].attrib
    row = row + 1
    dic['SNo'] = row
    dic['Description'] = root[0][i][0].text
    df = df.append(dic, ignore_index=True)
    print (row)


row = -1
for i in range(1, 50):
    tree = ET.parse('xmldata/photodata' + str(i) + ".xml") 
    root = tree.getroot()
    try:
        Parallel(n_jobs=4, backend='threading')(delayed(append_df)(i) for i in range(250))    
    except IndexError:
        continue

df.to_csv('PhotosData.csv', encoding='utf-8')
