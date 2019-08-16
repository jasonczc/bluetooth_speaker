from keras.models import *
from keras.preprocessing.sequence import pad_sequences
import Bid_data_setting
import os
import numpy as np
import time

os.environ['KMP_DUPLICATE_LIB_OK']='True' # for macos

resultMap = {1:'可回收垃圾',2:'有害垃圾',4:'湿垃圾',8:'干垃圾',16:'大件垃圾'};
model = load_model(os.path.abspath(os.path.dirname(__file__))+'/Bid_model.h5')

while True:
    print('告诉我你要扔什么垃圾')
    str = input()
    t = time.time()
    inputing = []
    for i in str:
        if i in Bid_data_setting.name_vocabulary:
            inputing.append(Bid_data_setting.dict_name_num[i])
    inputing = pad_sequences([inputing], maxlen=Bid_data_setting.pad_num, padding='post')
    prediction = model.predict(inputing)
    prediction = np.argmax(prediction, axis=-1)[0]
    print('你要扔的垃圾可能是', resultMap[prediction],'[',time.time()-t,'s]')