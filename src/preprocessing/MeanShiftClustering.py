import numpy as np
import pandas as pd
from sklearn.cluster import MeanShift, estimate_bandwidth
from sklearn.datasets.samples_generator import make_blobs
import matplotlib.pyplot as plt
from itertools import cycle
from PIL import Image
from sklearn.cluster import AffinityPropagation
from sklearn import metrics

#Reading the final CSV after removing duplicates
df = pd.read_csv('demodatawithoutdup.csv')

#Choosing the GPS features to cluster based on location
features = ['longitude', 'latitude']

#Filling NAs with 0s
df['longitude'].fillna(0, inplace=True)

#Dataframe with only the chosen features for all records
X = df[features]
x = X.as_matrix()

#Estimating appropriate bandwidth for Clustering
bandwidth = estimate_bandwidth(x, quantile=.002, n_samples=10000, random_state=100, n_jobs=4)

#Creating the MeanShift Model
ms = MeanShift(bandwidth=bandwidth, bin_seeding=True)

#Training the model
ms.fit(x)

#Finding the labels and clusters
labels = ms.labels_
cluster_centers = ms.cluster_centers_
n_clusters_ = labels.max()+1
print("Number of clusters = " + str(n_clusters_))

#Saving the new dataframe with clusters into a new csv
df['cluster'] = labels
df.to_csv('demodatawithoutdupcluster.csv')

#Plotting the clusters on world map
plt.figure(1)
plt.clf()
 
colors = cycle('bgrcmykbgrcmykbgrcmykbgrcmyk')
for k, col in zip(range(n_clusters_), colors):
    my_members = labels == k
    cluster_center = cluster_centers[k]
    plt.plot(x[my_members, 0], x[my_members, 1], col + '.')
    plt.plot(cluster_center[0], cluster_center[1],'+', markerfacecolor=col,markeredgecolor='k', markersize=10)
plt.title('Estimated number of clusters: %d' % n_clusters_)
plt.show()