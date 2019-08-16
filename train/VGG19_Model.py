from keras.models import Model
from keras.layers import Input, Conv2D, MaxPooling2D, Flatten, Dense, Dropout
from keras import regularizers
import numpy as np
import data_setting
import settings
import os
os.environ["CUDA_VISIBLE_DEVICES"] = "3"

def datas_generator(images_datas, labels_datas, batch_size):
    while True:
        row = np.random.randint(0, len(images_datas), size=batch_size)
        images_datas = np.array(images_datas)[row]
        labels_datas = np.array(labels_datas)[row]
        yield images_datas, labels_datas

input_datas = Input(shape=(settings.img_rows, settings.img_cols, settings.img_channels, ), dtype='float32')

Conv2D_1_1 = Conv2D(64, (3, 3), activation='relu')(input_datas)
Conv2D_1_2 = Conv2D(64, (3, 3), activation='relu')(Conv2D_1_1)
MaxPooling2D_1 = MaxPooling2D((2, 2), strides=(1, 1))(Conv2D_1_2)

Conv2D_2_1 = Conv2D(128, (3, 3), activation='relu')(MaxPooling2D_1)
Conv2D_2_2 = Conv2D(128, (3, 3), activation='relu')(Conv2D_2_1)
MaxPooling2D_2 = MaxPooling2D((2, 2), strides=(1, 1))(Conv2D_2_2)

Conv2D_3_1 = Conv2D(256, (3, 3), activation='relu')(MaxPooling2D_2)
Conv2D_3_2 = Conv2D(256, (3, 3), activation='relu')(Conv2D_3_1)
Conv2D_3_3 = Conv2D(256, (3, 3), activation='relu')(Conv2D_3_2)
Conv2D_3_4 = Conv2D(256, (3, 3), activation='relu')(Conv2D_3_3)
MaxPooling2D_3 = MaxPooling2D((2, 2), strides=(1, 1))(Conv2D_3_4)

Conv2D_4_1 = Conv2D(512, (3, 3), activation='relu')(MaxPooling2D_3)
Conv2D_4_2 = Conv2D(512, (3, 3), activation='relu')(Conv2D_4_1)
Conv2D_4_3 = Conv2D(512, (3, 3), activation='relu')(Conv2D_4_2)
Conv2D_4_4 = Conv2D(512, (3, 3), activation='relu')(Conv2D_4_3)
MaxPooling2D_4 = MaxPooling2D((2, 2), strides=(1, 1))(Conv2D_4_4)
Conv2D_4_5 = Conv2D(512, (3, 3), activation='relu')(MaxPooling2D_4)
Conv2D_4_6 = Conv2D(512, (3, 3), activation='relu')(Conv2D_4_5)
Conv2D_4_7 = Conv2D(512, (3, 3), activation='relu')(Conv2D_4_6)
Conv2D_4_8 = Conv2D(512, (3, 3), activation='relu')(Conv2D_4_7)
MaxPooling2D_5 = MaxPooling2D((2, 2), strides=(1, 1))(Conv2D_4_8)

Flatten_1 = Flatten()(MaxPooling2D_5)
Dense_1 = Dense(4096, activation='relu', activity_regularizer=regularizers.l1(settings.re_lamda))(Flatten_1)
Dropout_1 = Dropout(settings.dropout_rate)(Dense_1)
Dense_2 = Dense(4096, activation='relu', activity_regularizer=regularizers.l1(settings.re_lamda))(Dropout_1)
Dropout_2 = Dropout(settings.dropout_rate)(Dense_2)
Dense_3 = Dense(len(data_setting.objects_num), activation='softmax')(Dropout_2)
output_datas = Dense_3

model = Model(input_datas, output_datas)
model.compile(optimizer='Adam', loss='categorical_crossentropy', metrics=['accuracy'])
print('the model_summary is', model.summary())

try:
    model.fit_generator(datas_generator(data_setting.images_datas, data_setting.labels_datas, settings.batch_size), epochs=settings.epochs, steps_per_epoch=len(data_setting.images_datas)//(settings.batch_size))
except KeyboardInterrupt as e:
    model.save('/home/alzhu/bluetooth_speaker/train/VGG19_Model.h5')
    print('Model training stopped early and the weights has been saved.')

print('Model training completed.')
model.save('/home/alzhu/bluetooth_speaker/train/VGG19_Model.h5')