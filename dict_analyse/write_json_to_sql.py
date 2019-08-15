import pymysql
import json
import jieba
from concurrent.futures import ThreadPoolExecutor
#AUTHOR:jasonczc <jasonczc@qq.com>

host=""
user=""
password=""
database=""
charset=""

def write_to_db(itm):
    conn = pymysql.connect(host=host, user=user, password=password, database=database, charset=charset)
    cursor = conn.cursor()
    seg_list = jieba.cut_for_search(itm["name"])  # 搜索引擎模式
    stra = ",".join(seg_list)
    sql = "INSERT INTO classify (`name`,`tp`,`words`) VALUES (\"" + itm["name"] + "\"," + str(itm["categroy"]) + ",\""+stra+"\")"
    print(sql)
    res = cursor.execute(sql)
    print("run", itm)

conn = pymysql.connect(host=host, user=user, password=password, database=database, charset=charset)
cursor = conn.cursor()
try:
    sql = """
    CREATE TABLE classify (
    id INT auto_increment PRIMARY KEY ,
    name VARCHAR(50) NOT NULL,
    tp TINYINT NOT NULL,
    words VARCHAR(200)
    )ENGINE=innodb DEFAULT CHARSET=utf8;
    """
    # 执行SQL语句
    cursor.execute(sql)
except Exception:
    print("error")

executor = ThreadPoolExecutor(max_workers=12)
with open('garbage.json', 'r') as f:
    data = json.load(f)
    for itm in data:
        executor.submit(write_to_db,(itm))
