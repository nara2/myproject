

# test BLE Scanning software
# jcs 6/8/2014

import blescan
import sys
import time
import MySQLdb
import bluetooth._bluetooth as bluez

db_name="gps";
port=3306;
#chiwon home
chiwon_host="202.31.147.236";
#chiwon_host ="218.151.1.61"
chiwon_id="test";
chiwon_pw="1234";
#kootaek notebook
kootaek_host="";
kootaek_id="root1";
kootaek_pw="root";


#db = MySQLdb.connect(chiwon_host, chiwon_id, chiwon_pw, "gps" , 3306);
db = MySQLdb.connect(chiwon_host, chiwon_id, chiwon_pw, "gps" , 3306);
#db = MySQLdb.connect("114.70.197.203", "root", "root", "gps" , 8080);

curs = db.cursor();
#RSSI min2
min2 = 999
major = 0;
count = 0;
temp_min2 = 0
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
        #print beacon;
        resultList = [];
        if("24ddf4118cf1440c87cda368daf9c93e" in beacon):
            resultList.append(beacon);
            print resultList;
            for i in resultList:
                #print len(i);
                #major number of one
                if(len(i) == 62):
                    #major
                    print i[51:52];
                    #rssi
                    print i[60:62];

                    #if (flag == 0):
                    #    min2 = i[60:62];
                    temp_min2 = int(i[60:62]);
                    temp_major = int(i[51:52]);
                    #else :
                    #    x = i[60:62];

                #major number of two
                elif(len(i) == 64):
                    #major
                    print i[51:53];
                    #rssi
                    print i[62:64];

                    #if(flag == 0):
                    #    min2 = i[62:64]; 
                    temp_min2 = int(i[62:64]);
                    temp_major = int(i[51:53]);
                    #else :
                    #    y = i[62:64];

                else:
                    pass;

                if(temp_min2 < min2):
                    min2 = temp_min2;
                    major = temp_major;
                else:
                    pass;

        else:
            pass;

    print "min2 :"
    print min2;
    print "temp_min2:"
    print temp_min2;
    
    count+=1;
    if(major == min2):
        pass;
    else:
        if major !=0 or min2 !=999:    
            curs.execute("UPDATE bangle SET request_rssi = (%d) WHERE bangle_id = 2" %int(min2));
            curs.execute("UPDATE bangle SET request_major = (%d) WHERE bangle_id = 2" %int(major));
	if count == 10 and (major !=0 or min2 !=999):
	    curs.execute("INSERT INTO movement(bangle_id, request_major, time) values(2, (%d), now())" %int(major));
	    count = 0;
    db.commit()
    major = 0;
    min2 = 999;

