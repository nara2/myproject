

# test BLE Scanning software
# jcs 6/8/2014

import blescan
import sys
import time
import MySQLdb
import bluetooth._bluetooth as bluez

db_name="";
port=;
#chiwon home
host="";
id="test";
pw="1234";
db="";
port="";

db = MySQLdb.connect(host, id, pw, db, port);

curs = db.cursor();

start = 0;
rssi = 999
major = 0;
count = 0;
temp_rssi = 0
temp_major = 0;
dev_id = 0
try:
	sock = bluez.hci_open_dev(dev_id)
	print "ble thread started"

except:
	print "error accessing bluetooth device..."
    	sys.exit(1)

blescan.hci_le_set_scan_parameters(sock)
blescan.hci_enable_le_scan(sock)

while True:
    returnedList = blescan.parse_events(sock, 50);
    print "----------";
    time.sleep(0.5);
    for beacon in returnedList:
        resultList = [];
        if("24ddf4118cf1440c87cda368daf9c93e" in beacon):
            resultList.append(beacon);
            print resultList;
            for i in resultList:
                #major a single digit
                if(len(i) == 62):
                    #major
                    print i[51:52];
                    #rssi
                    print i[60:62];

                    temp_rssi = int(i[60:62]);
                    temp_major = int(i[51:52]);
                #major a double digit
                elif(len(i) == 64):
                    #major
                    print i[51:53];
                    #rssi
                    print i[62:64];

                    temp_rssi = int(i[62:64]);
                    temp_major = int(i[51:53]);
                else:
                    pass;

                if(temp_rssi < rssi):
                    rssi = temp_rssi;
                    major = temp_major;
                else:
                    pass;

        else:
            pass;

	print rssi;
	print major;

    if(major == rssi):
        pass;
    else:
        if start != 0 and  (major !=0 or rssi !=999):
            curs.execute("UPDATE bangle SET request_rssi = (%d) WHERE bangle_id = 1" %int(rssi));
            curs.execute("UPDATE bangle SET request_major = (%d) WHERE bangle_id = 1" %int(major));
	if start == 0 and (major !=0 or rssi !=999):
	    curs.execute("INSERT INTO movement(bangle_id, request_major, time) values(1, (%d), now())" %int(major));
	    count = 0;

	start += 1;
    db.commit()
    major = 0;
    rssi = 999;
