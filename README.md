# Dystopia Prices

 ## Description
 Website that tracks products from pcbox introducing the url.
 to get the information of the products uses a python script which gets the price, store the price and the timestamp on a mysql database.

 ## Installation
 To run this project, you need to install the required dependencies. follow the steps below:

 1. Clone the repository:

    ```bash
    git clone https://github.com/samuelavilesc/dystopia_prices.git
 2. Use XAMPP OR MAMPP to host the website, move all the repository content to htcdocs (also you can host the website)

 3. Install dependencies
 (on python folder)
     ```bash
     pip install -r requirements.txt
 4. Modify the DB conection parameters on "conexiobdb.php"
 5. Run the website, register a user, login, add a product and execute the python script to update the price and the chart of the panel.
