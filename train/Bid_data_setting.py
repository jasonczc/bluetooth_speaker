from keras.utils import to_categorical
from keras.preprocessing.sequence import pad_sequences
import numpy as np
import json
import random
import os
import glob
import settings

# labels处理
labels_file_path = 'datas/garbage.json'
with open(labels_file_path, encoding='UTF-8') as json_file:
    objects_name_label = json.load(json_file)
name_vocabulary = set()
label = []
for i in objects_name_label:
    for char in i['name']:
        if char not in name_vocabulary:
            name_vocabulary.add(char)
    label.append(i['categroy'])
name_vocabulary = sorted(name_vocabulary)
dict_name_num = dict([(char, i) for i, char in enumerate(name_vocabulary)])
dict_num_name = dict([(i, char) for char, i in dict_name_num.items()])
sum = len(label)
target_datas = np.array(to_categorical(label))

input_datas = []
for i in objects_name_label:
    inputing = []
    for char in i['name']:
        inputing.append(dict_name_num[char])
    input_datas.append(inputing)
pad_num = max([len(text) for text in input_datas])
input_datas = np.array(pad_sequences(input_datas, maxlen=pad_num, padding='post'))

index = []
for i in range(0, sum):
    index.append(i)
random.shuffle(index)

shuffle_input_datas, shuffle_target_datas = [], []
for i in index:
    shuffle_input_datas.append(input_datas[i])
    shuffle_target_datas.append(target_datas[i])

shuffle_input_datas = np.array(shuffle_input_datas)
shuffle_target_datas = np.array(shuffle_target_datas)


