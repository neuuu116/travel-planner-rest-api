-- Trip Packages Sample Data
-- Run this after schema.sql to insert sample packages

USE travel_planner;

-- Insert sample trip packages
INSERT INTO trip_packages (title, destination, duration_days, price, highlights, image_url, rating) VALUES
(
    'Kerala Backwaters Bliss',
    'Kerala',
    5,
    24999.00,
    '["Houseboat Stay", "Alleppey Backwaters", "Kumarakom Bird Sanctuary", "Traditional Kerala Meals", "Sunset Cruise"]',
    'https://images.unsplash.com/photo-1602216056096-3b40cc0c9944?w=800',
    4.7
),
(
    'Munnar Hills & Tea Gardens',
    'Kerala',
    4,
    18999.00,
    '["Tea Plantation Tour", "Eravikulam National Park", "Mattupetty Dam", "Echo Point", "Spice Garden Visit"]',
    'https://images.unsplash.com/photo-1595658658481-d53d3f999875?w=800',
    4.5
),
(
    'Goa Beach Paradise',
    'Goa',
    4,
    15999.00,
    '["North Goa Beaches", "Dudhsagar Waterfalls", "Old Goa Churches", "Sunset Cruise", "Water Sports"]',
    'https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?w=800',
    4.6
),
(
    'Rajasthan Royal Heritage',
    'Rajasthan',
    7,
    45999.00,
    '["Jaipur City Palace", "Udaipur Lake Pichola", "Jodhpur Mehrangarh Fort", "Desert Safari", "Camel Ride", "Folk Dance"]',
    'https://images.unsplash.com/photo-1477587458883-47145ed94245?w=800',
    4.8
),
(
    'Andaman Island Escape',
    'Andaman & Nicobar',
    6,
    34999.00,
    '["Radhanagar Beach", "Cellular Jail", "Scuba Diving", "Havelock Island", "Coral Reef", "Glass Bottom Boat"]',
    'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800',
    4.9
);
