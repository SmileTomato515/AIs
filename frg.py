"""
@author: Jacky
"""

import time
import face_recognition
import cv2
import pickle
import numpy as np
from imutils.video import VideoStream
import imutils
#connect to php
import requests 
#connect to arduino
import serial
import time
from time import sleep

ser = serial.Serial("/dev/serial0",9600,timeout=1) #serial initialize

usingPiCamera = True # Are we using the Pi Camera?
frameSize = (320, 240) # Set initial frame size. It can be # final
 
vs = VideoStream(src=0, usePiCamera=usingPiCamera, resolution=frameSize,
		framerate=32).start() # Initialize mutithreading the video stream.

time.sleep(2.0) # Allow the camera to warm up.

# Load face encodings
with open('dataset_faces_newest.dat', 'rb') as f:
	all_face_encodings = pickle.load(f)

# Grab the list of names and the list of encodings
face_namess = list(all_face_encodings.keys())
known_face_encodings = np.array(list(all_face_encodings.values()))  #known face

# Initialize some variables
face_locations = []
face_encodings = [] #unknown face
face_names = []
process_this_frame = True

while True:
    # Grab a single frame of video
    frame = vs.read()

    # Resize frame of video to 1/4 size for faster face recognition processing
    small_frame = cv2.resize(frame, (0, 0), fx=0.25, fy=0.25)

    # Convert the image from BGR color (which OpenCV uses) to RGB color (which face_recognition uses)
    rgb_small_frame = small_frame[:, :, ::-1]

    # Only process every other frame of video to save time
    if process_this_frame:
        # Find all the faces and face encodings in the current frame of video
        face_locations = face_recognition.face_locations(rgb_small_frame)
        face_encodings = face_recognition.face_encodings(rgb_small_frame, face_locations)

        face_names = []
        for face_encoding in face_encodings:
            # See if the face is a match for the known face(s)
            matches = face_recognition.compare_faces(known_face_encodings, face_encoding, tolerance=0.42)
            name = "Unknown"

            # If a match was found in known_face_encodings, just use the first one.
            if True in matches:
                first_match_index = matches.index(True)
                name = face_namess[first_match_index]
                print(name)

                #php
                path="http://smiletomato.ddns.net:8888/AIs/phppy.php?data="
                id = name
                url= path + id
                req=requests.get(url)
                
                str = req.text
                print(str)
                ser.write(str.encode())
                print('tx')
    
                # Hit 'q' on the keyboard to quit!
                if cv2.waitKey(1) & 0xFF == ord('q'):
                    break

    process_this_frame = not process_this_frame

    # Display the resulting image
    cv2.imshow('Video', frame)

    # Hit 'q' on the keyboard to quit!
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

cv2.destroyAllWindows()