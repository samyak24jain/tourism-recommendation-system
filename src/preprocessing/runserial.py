import serialparsing

step = 10

for i in range(1,1700,step):
	serialparsing.xmltocsv(i, step)
	print(i)
	