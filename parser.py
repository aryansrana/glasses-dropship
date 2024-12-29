import sys
import xml.dom.minidom
import mysql.connector

def insert(cursor, glasses_id, name, description, price, image, review, pair_id):
    query = 'INSERT INTO glasses(glasses_id,name,description,price,image,review, pair_id) VALUES (%s,%s,%s,%s,%s,%s,%s)'
    cursor.execute(query, (glasses_id, name, description, price, image, review, pair_id))

def update(cursor, glasses_id, name, description, price, image, review, pair_id):
    query = 'UPDATE glasses SET name=%s, description=%s, price=%s, image=%s, review=%s, pair_id=%s WHERE glasses_id=%s'
    cursor.execute(query, (name, description, price, image, review, pair_id, glasses_id))

def insert2(cursor, glasses_id, name, description, price, image, pair_id):
    query = 'INSERT INTO glasses(glasses_id,name,description,price,image,review, pair_id) VALUES (%s,%s,%s,%s,%s,NULL,%s)'
    cursor.execute(query, (glasses_id, name, description, price, image, pair_id))

def update2(cursor, glasses_id, name, description, price, image, pair_id):
    query = 'UPDATE glasses SET name=%s, description=%s, price=%s, image=%s, review=NULL, pair_id=%s WHERE glasses_id=%s'
    cursor.execute(query, (name, description, price, image, pair_id, glasses_id))

document = xml.dom.minidom.parse(sys.argv[1])

try:
    cnx = mysql.connector.connect(host='localhost', user='root', password='112784', database='dropship')
    cursor = cnx.cursor()

    file_name = sys.argv[1]
    glasses_id = int(file_name.strip(".xhtml"))


    if glasses_id <= 25:
        pair_id = glasses_id
        
        #name
        name = ""
        ol_list = document.getElementsByTagName('ol')
        for ol in ol_list:
            if ol.hasAttribute('class'):
                if ol.getAttribute('class') == "list-unstyled list-inline bg-gray-lightest border-bottom padding-right-15-md padding-left-20-md margin-bottom-0 hidden-xs hidden-sm":
                    li = ol.childNodes[1]
                    span = li.childNodes[1]
                    name = span.childNodes[0].nodeValue
                    name = name.replace("&nbsp", " ")
                    name = name.replace("  ", " ")
                    name = name.rstrip('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~ \t\n\r\x0b\x0c')

        #description
        description = ""
        p_list = document.getElementsByTagName('p')
        for p in p_list:
            if p.hasAttribute('class'):
                if p.getAttribute('class') == "font-small-xs line-height-15":
                    children = p.childNodes
                    for child in children:
                        if child.nodeType == child.TEXT_NODE:
                            description = child.nodeValue
                            break
            if description != "":
                break
        
        children=[]
        #price
        price = ""
        span_list = document.getElementsByTagName('span')
        for span in span_list:
            if span.hasAttribute('id'):
                if span.getAttribute('id') == "oldPrice":
                    children = span.childNodes
                    for child in children:
                        if child.nodeType == child.TEXT_NODE:
                            price = child.nodeValue
                            break
            if price != "":
                break
        
        children=[]
        
        #image
        image = ""
        img_list = document.getElementsByTagName('img')
        for img in img_list:
            if img.hasAttribute('class'):
                if img.getAttribute('class') == "img-responsive padding-left-15":
                    if img.hasAttribute('src'):
                        image = img.getAttribute('src')
                        break
        
        #ratings
        rating = ""
        div_list = document.getElementsByTagName('div')
        for div in div_list:
            if div.hasAttribute('class'):
                if div.getAttribute('class') == "rates visible-inline-block line-height-10":
                    if div.hasAttribute('data-rating'):
                        rating = div.getAttribute('data-rating')
                        break
    else:
        pair_id = glasses_id - 25
        #name
        name = ""
        h1_list = document.getElementsByTagName("h1")
        for h1 in h1_list:
            if h1.hasAttribute('class'):
                if h1.getAttribute('class') == "product-name":
                    children = h1.childNodes
                    for child in children:
                        if child.nodeType == child.TEXT_NODE:
                            name = child.nodeValue
                            break
            if name != "":
                break

        #description
        description = ""
        p_list = document.getElementsByTagName("p")
        for p in p_list:
            if p.hasAttribute("itemprop"):
                if p.getAttribute("itemprop") == "description":
                    children = p.childNodes
                    for child in children:
                        if child.nodeType == child.TEXT_NODE:
                            description = child.nodeValue
                            break
            if description != "":
                break

        #price
        price = ""
        span_list = document.getElementsByTagName("span")
        for span in span_list:
            if span.hasAttribute("class"):
                if span.getAttribute("class") == "normal-price price-symbol":
                    children = span.childNodes
                    for child in children:
                        if child.nodeType == child.TEXT_NODE:
                            price = child.nodeValue
                            break
            if price != "":
                break

        #image
        image = ""
        div_list = document.getElementsByTagName('div')
        for div in div_list:
            if div.hasAttribute('id'):
                if div.getAttribute('id') == "js-current-image":
                    children = div.childNodes
                    for child in children:
                        if child.nodeType == child.ELEMENT_NODE and child.hasAttribute("src"):
                            image = child.getAttribute("src")
                            break
                
        #ratings
        rating = ""
        span_list = document.getElementsByTagName('span')
        for span in span_list:
            if span.hasAttribute("class"):
                if span.getAttribute("class") == "num":
                    children = span.childNodes
                    for child in children:
                        if child.nodeType == child.TEXT_NODE:
                            rating = child.nodeValue
                            break
            if rating != "":
                break

    #Retrieved all data from xhtml page

    #clean up the data
    name = name.strip()
    description = description.strip()
    price = price.strip()
    price = price.strip("$")
    image = image.strip()
    rating = rating.strip()

    '''
    print(glasses_id)
    print(pair_id)
    print(name)
    print(description)
    print(price)
    print(image)
    print(rating)
    '''
    
    #Insert data into db
    query = 'SELECT * FROM glasses WHERE glasses_id = %s'
    cursor.execute(query, (glasses_id,))
    rows = cursor.fetchall()

    if len(rows) == 0:
        if rating != "" and rating != "0":
            insert(cursor, glasses_id, name, description, price, image, rating, pair_id)
        else:
            insert2(cursor, glasses_id, name, description, price, image, pair_id)
    else:
        if rating != "" and rating != "0":
            update(cursor, glasses_id, name, description, price, image, rating, pair_id)
        else:
            update2(cursor, glasses_id, name, description, price, image, pair_id)
    
    cnx.commit()
    
    cnx.close()
except mysql.connector.Error as err:
    print(err)
finally:
    try:
        cnx
    except NameError:
        pass
    else:
        cnx.close()
