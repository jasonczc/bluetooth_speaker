from keras.layers import *
from keras.models import *

import Bid_data_setting
import settings
import os

inputing = Input(shape=(Bid_data_setting.pad_num, ))
embedding = Embedding(len(Bid_data_setting.name_vocabulary), settings.embedding_dim, input_length=Bid_data_setting.pad_num, trainable=True)(inputing)
bid = Bidirectional(LSTM(settings.LSTM_neurons, return_sequences=True), merge_mode='concat', trainable=True)(embedding)
conv1d_1 = Conv1D(settings.filters_1, kernel_size=settings.kernel_size, padding='valid', activation='relu')(bid)
conv1d_2 = Conv1D(settings.filters_2, kernel_size=settings.kernel_size, padding='valid', activation='relu')(conv1d_1)
maxpooling1d_1 = MaxPooling1D()(conv1d_2)
conv1d_3 = Conv1D(settings.filters_3, kernel_size=settings.kernel_size, padding='valid', activation='relu')(maxpooling1d_1)
conv1d_4 = Conv1D(settings.filters_4, kernel_size=settings.kernel_size, padding='valid', activation='relu')(conv1d_3)
maxpooling1d_2 = MaxPooling1D()(conv1d_4)
flatten = Flatten()(maxpooling1d_2)
dense_1 = Dense(512, activation='tanh')(flatten)
dense_2 = Dense(5, activation='softmax')(dense_1)
outputing = dense_2
model = Model(inputing, outputing)

model.compile(optimizer='rmsprop', loss='categorical_crossentropy', metrics=['acc'])
print('the summary of the model is')
model.summary()

try:
    model.fit(Bid_data_setting.input_datas, Bid_data_setting.target_datas, epochs=settings.epochs, steps_per_epoch=settings.step_per_epoch)
except:
    model.save(os.path.abspath(os.path.dirname(__file__))+'/Bid_model.h5')
    print('the model has been saved.')

model.save(os.path.abspath(os.path.dirname(__file__))+'/Bid_model.h5')
print('the model has been saved.')



