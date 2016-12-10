from scipy.spatial import distance as dist
import matplotlib.pyplot as plt
import pandas as pd
import numpy as np
import glob
import cv2
import operator


df = pd.read_csv('demodatawithoutdupcluster.csv')
labels = list(df['cluster'])

# Code to find the Representative Tags (or R-Tags) of the clusters

dictlist=[]

for i in range(0,max(labels)+1):
    result={}
    dfcluster=pd.DataFrame()
    dfcluster= df[df['cluster'] == i]
    result=dfcluster.tags.apply(lambda x: pd.value_counts(str(x).split(" "))).sum(axis = 0)
    if(len(result)>30):
        result=sorted(result.iteritems(),key=operator.itemgetter(1),reverse=True)[:30]
    else:
        result=sorted(result.iteritems(),key=operator.itemgetter(1),reverse=True)
    dictlist.append(result)



# Code to find the Representative Images (or R-Images) of the clusters

index = {}
images = {}

for imagePath in glob.glob("imagesfinal/*.jpg"):
    # extract the image filename (assumed to be unique) and
    # load the image, updating the images dictionary
    filename = imagePath[imagePath.rfind("/") + 1:]
    image = cv2.imread(imagePath)
    images[filename] = cv2.cvtColor(image, cv2.COLOR_BGR2RGB)

    # extract a 3D RGB color histogram from the image,
    # using 8 bins per channel, normalize, and update
    # the index
    hist = cv2.calcHist([image], [0, 1, 2], None, [8, 8, 8],
        [0, 256, 0, 256, 0, 256])
    hist = cv2.normalize(hist).flatten()
    index[filename] = hist


#Choosing the appropriate method to compare histograms

method = cv2.cv.CV_COMP_CHISQR 
methodName = "Chi-Squared"

image_filename = "photo_8346847065.jpg"

# initialize the results dictionary

results = []

# for i in range(0, max(labels)+1):

dfcluster = df[df['cluster'] == 0]
exemplar = {}

for photoid in list(dfcluster['id']):
    exemplar['photo_' + str(photoid) + '.jpg'] = 0

i = 0

for photoid in list(dfcluster['id']):
    
    try:
        
        hist1 = index['photo_' + str(photoid) + '.jpg']
        ex = float('inf')
        best = photoid
        for check in list(dfcluster['id']):
            if photoid != check:
                hist2 = index['photo_' + str(check) + '.jpg']
                d = cv2.compareHist(hist1, hist2, method)
                if d < ex:
                    ex = d
                    best = check
        exemplar['photo_' + str(best) + '.jpg'] += 1
    except KeyError,e:
        print(e)
        i = i + 1
        continue


# sort the results
results = sorted([(v, k) for (k, v) in results.items()], reverse = False)

fig = plt.figure("Query Image")

ax = fig.add_subplot(1, 1, 1)

ax.imshow(images[image_filename])

plt.axis("off")

# initialize the results figure
fig = plt.figure("Results: %s" % (methodName))
fig.suptitle(methodName, fontsize = 20)

# loop over the results
for (i, (v, k)) in enumerate(results[:6]):
    # show the result
    ax = fig.add_subplot(2, 3, i + 1)
    ax.set_title("%s : %.2f" % (k, v))
    plt.imshow(images[k])
    plt.axis("off")

#show the figures
plt.show()
