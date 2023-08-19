import requests
from bs4 import BeautifulSoup
import time
from datetime import datetime
import mysql.connector

HEADERS = {
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3"
}

def initialize_database():
    conn = mysql.connector.connect(
        host="PMYSQL171.dns-servicio.com",
        user="mikaelsamuel",
        password="mikaelsamuel123",
        database="9807632_database"
    )
    cursor = conn.cursor()

    cursor.execute('''
        CREATE TABLE IF NOT EXISTS prices_new (
            id INT AUTO_INCREMENT PRIMARY KEY,
            url VARCHAR(255),
            timestamp DATETIME,
            price FLOAT
        )
    ''')

    conn.commit()
    conn.close()

def get_price(url):
    response = requests.get(url, headers=HEADERS)
    soup = BeautifulSoup(response.content, "html.parser")
    price_element = soup.find("span", {"class": "vtex-product-price-1-x-currencyInteger"})
    
    if price_element is None:
        print(f"Price element not found for URL: {url}. Skipping this iteration.")
        return None
    
    price = float(price_element.text.strip())
    return price

def save_price(url, price):
    current_time = datetime.now()

    conn = mysql.connector.connect(
        host="PMYSQL171.dns-servicio.com",
        user="mikaelsamuel",
        password="mikaelsamuel123",
        database="9807632_database"
    )
    cursor = conn.cursor()

    cursor.execute('''
        INSERT INTO prices_new (url, timestamp, price)
        VALUES (%s, %s, %s)
    ''', (url, current_time, price))

    conn.commit()
    conn.close()
    print("Price saved to database")

def main():
    initialize_database()

    conn = mysql.connector.connect(
        host="PMYSQL171.dns-servicio.com",
        user="mikaelsamuel",
        password="mikaelsamuel123",
        database="9807632_database"
    )
    cursor = conn.cursor()

    try:
        cursor.execute("SELECT url FROM products_pcbox")
        urls = cursor.fetchall()
        
        for url in urls:
            url = url[0]  # Extract the URL from the tuple
            price = get_price(url)
            if price is not None:
                print(f"URL: {url}, Current price: {price}")
                save_price(url, price)

            time.sleep(5)

    except KeyboardInterrupt:
        print("Script terminated by the user.")
    except Exception as e:
        print(f"An error occurred: {e}")
    finally:
        conn.close()

if __name__ == "__main__":
    main()
