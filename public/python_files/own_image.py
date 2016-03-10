#!/home/anshul/miniconda2/bin/python
import argparse
import random
from PIL import Image
import subprocess
from os import listdir
from os.path import isfile, join
import os
from keras.models import model_from_json
import sys
from spacy.en import English
import numpy as np
import scipy.io
from sklearn.externals import joblib
from features import get_questions_tensor_timeseries, get_images_matrix
from subprocess import Popen, PIPE, STDOUT

Dirc = '/home/anshul/innomania.com/public/model_data/'
def _log(str):
   f = open('/home/anshul/innomania.com/public/log/log.txt', 'a');
   f.write(str +"\r\n");
   f.close();
   pass

def main():
   parser = argparse.ArgumentParser()
   parser.add_argument('--model', type=str, default=Dirc+'lstm_1_num_hidden_units_lstm_512_num_hidden_units_mlp_1024_num_hidden_layers_mlp_3.json')
   parser.add_argument('--weights', type=str, default=Dirc+'lstm_1_num_hidden_units_lstm_512_num_hidden_units_mlp_1024_num_hidden_layers_mlp_3_epoch_070.hdf5')
   parser.add_argument('--sample_size', type=int, default=25)
   parser.add_argument('--caffe', default='/home/anshul/caffe-master',help='path to caffe installation')
   parser.add_argument('--model_def', help='path to model definition prototxt')
   parser.add_argument('--vggmodel', default=Dirc+'VGG_ILSVRC_16_layers.caffemodel', help='path to model parameters')
   parser.add_argument('--img', help='path to model parameters')
   parser.add_argument('--ques', help='path to model parameters')
   args = parser.parse_args()
   _log('Loading Word2vec')
   nlp = English()
   _log('Loaded word2vec features')
   labelencoder = joblib.load(Dirc+'labelencoder.pkl')
   _log('Loading Model')
   path = str(args.img)
   try:
      from keras.models import model_from_json
   except:
      _log("keras not Found")
   model = model_from_json(open(args.model).read())
   model.load_weights(args.weights)
   model.compile(loss='categorical_crossentropy', optimizer='rmsprop')
   _log('Loaded')
   q = True
   if path != 'same':
      wget = Popen(['python' , Dirc+'extract_features.py --caffe ' + str(args.caffe) + ' --model_def '+Dirc+'vgg_features.prototxt --gpu --model ' + str(args.vggmodel) + ' --image ' + path], stdout=PIPE, stderr=STDOUT)
      stdout, nothing = wget.communicate()
   _log('Loading VGGfeats')
   vgg_model_path = '/home/anshul/innomania.com/public/python_files/vgg_feats.mat'
   features_struct = scipy.io.loadmat(vgg_model_path)
   VGGfeatures = features_struct['feats']
   _log("Loaded")
   question = unicode(args.ques)
   if question == "quit":
      q = False
   timesteps = len(nlp(question))
   X_q = get_questions_tensor_timeseries([question], nlp, timesteps)
   X_i = np.reshape(VGGfeatures, (1, 4096))
   X = [X_q, X_i]
   y_predict = model.predict_classes(X, verbose=0)
   result = labelencoder.inverse_transform(y_predict)[0]
   f = open('/home/anshul/innomania.com/public/output_files/output_class.txt', 'wb');
   f.write(result);
   f.close();
   _log("Done")
   print labelencoder.inverse_transform(y_predict)[0]
main()