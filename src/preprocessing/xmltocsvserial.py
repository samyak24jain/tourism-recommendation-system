import xml.etree.ElementTree as ET
import pandas as pd
import numpy as np  
import time

tree = ET.parse('xmldata/photodata1.xml')
root = tree.getroot()
x = root[0][1].attrib.keys()

df = pd.DataFrame(columns=['SNo', 'Description'] + x)

row = -1
for i in range(1, 1700):
    tree = ET.parse('xmldata/photodata' + str(i) + ".xml") 
    root = tree.getroot()
    for i in range(250):
        try:
            dic = root[0][i].attrib
            row = row + 1
            dic['SNo'] = row
            dic['Description'] = root[0][i][0].text
            df = df.append(dic, ignore_index=True)
            print (row)
        except IndexError:
            break

df.to_csv('PhotosData.csv', encoding='utf-8')
