# bluetooth_speaker
我是小垃圾
依托Rokid平台进行的扩展

# 主要框架/语言
PHP+GOLANG+PYTHON

# 位置
 - camera  树莓派摄像头端(垃圾识别)
 - proxy   中转(用于与Rokid云函数的对调)
 - rec     识别端(用于使用训练后的模型)
 - speaker 音箱固件源码
 - spider  训练集收集用爬虫
 - train   人工智能训练(分类)

# 调用链
## 垃圾分类功能
### 图像识别
音箱->Rokid云函数->Proxy服务器->Camera树莓派(调起摄像头)->Rec识别服务
->Camera树莓派->Proxy服务器->Rokid云函数->音箱

### 语音询问
音箱->Rokid->Proxy(在Proxy直接处理)
->Rokid->音箱