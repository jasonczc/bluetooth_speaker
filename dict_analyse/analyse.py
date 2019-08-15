# encoding=utf-8
import jieba
import json

with open('garbage.json', 'r') as f:
    data = json.load(f)
    for itm in data:
        print(json.dumps(itm))

seg_list = jieba.cut("不锈钢杯子", cut_all=True) # 搜索引擎模式
x = print(123)
stra = ",".join(seg_list)
print(stra)