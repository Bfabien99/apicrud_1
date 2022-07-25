# CRUD API WITH SYMFONY
- run "composer install" to install all dependencies

# API domaine name
- All API requests should be made to: https://your_host/api/v1

# LISTEN ROUTES
- '/products' method : GET
- '/product' method : POST
- '/product/{id}' method : GET
- '/product/{id}' method : POST
- '/product/{id}' method : DELETE

# '/products'
- List all product available

# POST '/product'
- Create a new product

# GET '/product/{id}'
- Get a specific product

# POST '/product/{id}'
- Update a specific product

# DELETE '/product/{id}'
- Delete a specific product

# About 'Product'
- Product should have :
    - title : string 255 not null
    - description : text null
    - price : integer not null
    - image_url : text not null

{
    "title": "a title",
    "description": "a description",
    "price": 3,
    "image_url": "https://www.example.org"
}