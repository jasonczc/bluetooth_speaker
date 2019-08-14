import re
from concurrent.futures.thread import ThreadPoolExecutor

import requests
from urllib import error
from bs4 import BeautifulSoup
import os
import json
from PIL import Image
import os.path
import glob

numPicture = 0
def Find(url, target_num):
    list = []
    print('正在检测图片总数，请稍等.....')
    t = 0 # sum of now pic
    while t < target_num:
        Url = url + str(t)
        try:
            Result = requests.get(Url, timeout=7)
        except BaseException:
            t = t + 60
            continue
        else:
            result = Result.text#html
            pic_url = re.findall('"objURL":"(.*?)",', result, re.S)  # 先利用正则表达式找到图片url
            t += len(pic_url)
            if len(pic_url) == 0: #has no pic
                break
            else:
                for v in pic_url:
                    list.append(v)
    return list


# download pic to file
def download_picture(urls, keyword, file, numPicture):
    tmp = 1
    for each in urls:
        if tmp > numPicture:
            break
        print('图片地址:',each,"|[",keyword,"]第[",tmp,"]个")
        try:
            if each is not None:
                pic = requests.get(each, timeout=17)
            else:
                continue
        except BaseException:
            print('错误，当前图片无法下载')
            continue
        else:
            tmp += 1
            string = file + r'/' + keyword + '_' + str(tmp) + '.jpg'
            fp = open(string, 'wb')
            fp.write(pic.content)
            fp.close()

    for jpgfile in glob.glob(file + "/*.jpg"):
        convert_jpg(jpgfile, file)
    return


def convert_jpg(jpgfile, outdir, width=299, height=299):
    try:
        img = Image.open(jpgfile)
        new_img = img.resize((width, height), Image.BILINEAR)
        new_img.save(os.path.join(outdir, os.path.basename(jpgfile)))
    except Exception as e:
        print(e)
        os.remove(jpgfile)


def load_word(word): # loader of async function
    url = 'http://image.baidu.com/search/flip?tn=baiduimage&ie=utf-8&word=' + word + '&pn='
    pic_urls = Find(url, numPicture) # find pic count of every word
    print(len(pic_urls))
    file = word
    # create path
    if os.path.exists(file) == 0:
        os.mkdir(file)

    download_picture(pic_urls, word, file, numPicture)


if __name__ == '__main__':  # 主函数入口
    numPicture = int(input('请输入每类图片的下载数量 '))
    with open('list.json', 'r') as f:
        line_list = json.load(f)

    executor = ThreadPoolExecutor(max_workers=32)

    for word in line_list:
        executor.submit(load_word,(word))
