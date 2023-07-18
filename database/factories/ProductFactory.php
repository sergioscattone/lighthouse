<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productNames = [ "iPhone", "Samsung Galaxy", "MacBook Pro", "PlayStation", "Xbox", "Nintendo Switch", "Fitbit Charge", "GoPro Hero",
            "Kindle Paperwhite", "Dyson Vacuum", "Nespresso Coffee Machine", "Bose Noise-Cancelling Headphones", "Canon EOS Camera",
            "Sony 4K Smart TV", "Microsoft Surface Pro", "Garmin Fitness Tracker", "Roomba Robot Vacuum", "Apple Watch", "Google Pixel",
            "Sonos Speaker", "Instant Pot", "Nutribullet Blender", "JBL Bluetooth Speaker", "LG OLED TV", "Keurig Coffee Maker", "Nikon DSLR Camera",
            "Breville Toaster Oven", "AirPods", "Fitbit Versa", "Samsung QLED TV", "Amazon Echo", "Ring Video Doorbell", "iPad Pro",
            "KitchenAid Stand Mixer", "Bose Soundbar", "Apple TV", "Sony Noise-Cancelling Headphones", "Nintendo Switch Lite", "DJI Mavic Drone",
            "Beats Wireless Earphones", "Roku Streaming Stick", "Jabra Elite Earbuds", "Vitamix Blender", "Fujifilm Instax Camera",
            "Logitech Wireless Mouse", "GoPro Hero Session", "Fitbit Inspire", "Bose QuietComfort Headphones", "Sony PlayStation VR",
            "Microsoft Xbox Series X", "Apple MacBook Air", "Canon Powershot Camera", "Samsung Soundbar", "Google Nest Thermostat", "Ninja Foodi",
            "JBL Flip Speaker", "LG 4K UHD TV", "Sony Alpha Mirrorless Camera", "Instant Pot Duo", "Cuisinart Food Processor", "Garmin Smartwatch",
            "Razer Gaming Mouse", "Amazon Kindle", "Philips Hue Smart Bulbs", "Bose Home Speaker", "Dyson Air Purifier", "Nespresso Vertuo",
            "iRobot Braava Jet", "Apple AirPods Pro", "Fitbit Sense", "Samsung Frame TV", "Microsoft Surface Laptop", "Sony Bluetooth Speaker",
            "NVIDIA GeForce Graphics Card", "Logitech Webcam"
        ];
        return [
            'name' => $productNames[array_rand($productNames)],
            'price' => fake()->randomFloat('2', 0, 200),
        ];
    }
}
