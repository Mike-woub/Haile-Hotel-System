import requests
import json

# Define the API endpoint and parameters
user_id = 1  # Example user ID
num_recommendations = 3  # Number of recommendations
url = f"http://9b2f-155-94-249-91.ngrok-free.app/recommend?user_id={user_id}&num_recommendations={num_recommendations}"

# Make the API request
response = requests.get(url)

# Check if the request was successful
if response.status_code == 200:
    try:
        recommendations = response.json()
        if isinstance(recommendations, list):
            for recipe in recommendations:
                print(recipe)
        else:
            print("No recommendations found.")
    except json.JSONDecodeError:
        print("Failed to decode JSON response.")
        print(f"Response: {response.text}")
else:
    print("Failed to fetch recommendations.")
    print(f"Status Code: {response.status_code}")
    print(f"Response: {response.text}")
