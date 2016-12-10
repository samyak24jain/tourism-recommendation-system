import xml.etree.ElementTree as ET
import pandas as pd
import numpy as np  
import time

def xmltocsv(a, step):

    b = a + step

    tree = ET.parse('xmldata/photodata1.xml')
    root = tree.getroot()
    x = root[0][1].attrib.keys()

    df = pd.DataFrame(columns=['SNo', 'Description'] + x)

    row = -1
    for j in range(a, b):
        tree = ET.parse('xmldata/photodata' + str(j) + ".xml") 
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

    df.to_csv('csvdata/PhotosData' + str(a) + '.csv', encoding='utf-8')
