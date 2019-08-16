from keras.utils import to_categorical
import cv2 as cv
import numpy as np
import json
import os
import glob
import settings
import random

# labels处理
labels_file_path = '/home/alzhu/bluetooth_speaker/spider_1/objects_labels.json'
with open(labels_file_path, encoding='UTF-8') as json_file:
    objects_name = json.load(json_file)
objects_name_vocab = set()
objects_num = []
objects_num_name = {}
for i in range(len(objects_name)):
    name = objects_name[i]
    if name not in objects_name_vocab:
        objects_name_vocab.add(name)
    objects_num.append(i)
    objects_num_name[i] = name
objects_num_name = dict(objects_num_name)
objects_name_num = dict([(char, i) for i, char in objects_num_name.items()])
objects_num = to_categorical(objects_num)

# images处理
images_datas = []
labels_datas = []
def get_picture(img_path):
    img = cv.imread(img_path)# 加载RGB图片或灰度图片
    img = cv.resize(img, (settings.img_rows, settings.img_cols))
    img = np.array(img)# 将图片的像素矩阵转化为一个向量
    img = img / 255
    images_datas.append(img)
all_images_full_path = []
all_images_label = []
images_file_path = '/home/alzhu/bluetooth_speaker/datas/'
images_files = glob.glob(images_file_path + '*')
for f in images_files:# 每个f为一个分类
    f_picture = f[36:]
    print(f_picture)
    for parent, dirnames, filenames in os.walk(f, followlinks=True):
        for filename in filenames:
            all_images_full_path.append(f + '/' + filename)
            all_images_label.append(objects_name_num[f_picture])

index = []
for i in range(0, len(all_images_full_path)):
    index.append(i)
random.shuffle(index)

for i in index:
    get_picture(all_images_full_path[i])
    labels_datas.append(objects_name_num[all_images_label[i]])

labels_datas = to_categorical(labels_datas)









