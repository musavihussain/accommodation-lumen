<?php

namespace App\Http\Controllers;

use App\Accommodation;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AccommodationController extends Controller {

    public function createAccommodation(Request $request) {
        // Validation of request
        $this->validate($request, [
            'name' => 'max:10',
            'rating' => 'numeric | between:0,5',
            'category' => 'string',
            'zip_code' => 'numeric | digits:6',
            'url' => 'url',
            'reputation' => 'numeric | between:0,1000',
            'price' => 'numeric',
            'availability' => 'numeric'
        ]);

        if(Str::contains($request->name, ["Free", "Offer", "Book", "Website"])) {
            return response()->json('Please try to choose another name. [Name should not include: free, offer, book and website]');
        }
        $category = ["hotel", "alternative", "hostel", "lodge", "resort", "guest-house"];
        if(!in_array($request->category, $category)) {
            return response()->json('Please select appropriate category from list [hostel, alternative, hotel, lodge, resort, guest-house');
        }

        $accommodation = new Accommodation();
        $accommodation->name = $request->name;
        $accommodation->rating = $request->rating;
        $accommodation->category = $request->category;
            // Insert location
            $location = new Location();
            $location->city = $request->city;
            $location->state = $request->state;
            $location->country = $request->country;
            $location->zip_code = $request->zip_code;
            $location->address = $request->address;
            $location->save();
        $accommodation->location_id = $location->id;
        $accommodation->image = $request->image;
        $accommodation->reputation = $request->reputation;
        if($request->reputation  <= 500) {
            // For exact code of color, need to discuss with front-end developer
            $accommodation->reputations_badge = "red";
        }
        elseif($request->reputation  <= 799) {
            $accommodation->reputations_badge = "yellow";
        }
        else{
            $accommodation->reputations_badge = "green";
        }
        $accommodation->price = $request->price;
        $accommodation->availability = $request->availability;
        $accommodation->save();

        return response()->json('Successfully inserted!');
    }

    public function getAllAccommodation() {
        return Accommodation::
        with('location')
        ->get();
    }

    public function getSingleAccommodation(Request $request) {
        return Accommodation::find($request->id)
        ->with('location')
        ->get();
    }

    public function updateAccommodation(Request $request) {
        $accommodation = Accommodation::find($request->id);
        $accommodation->name = $request->name ? $request->name : $accommodation->name;
        $accommodation->rating = $request->rating ? $request->rating : $accommodation->rating;
        $accommodation->category = $request->category ? $request->category : $accommodation->category;
            // Insert location
            if($request->location_id) {
                $location = Location::find($request->location_id);
                $location->city = $request->city ? $request->city : $location->city;
                $location->state = $request->state ? $request->state : $location->state;
                $location->country = $request->country ? $request->country : $location->country;
                $location->zip_code = $request->zip_code ? $request->zip_code : $location->zip_code;
                $location->address = $request->address ? $request->address : $location->address;
                $location->save();
            }

        $accommodation->image = $request->image ? $request->image : $accommodation->image;
        $accommodation->reputation = $request->reputation ? $request->reputation : $accommodation->reputation;
        if($request->reputation  <= 500) {
            // For exact code of color, need to discuss with front-end developer
            $accommodation->reputations_badge = "red";
        }
        elseif($request->reputation  <= 799) {
            $accommodation->reputations_badge = "yellow";
        }
        else{
            $accommodation->reputations_badge = "green";
        }
        $accommodation->price = $request->price ? $request->price : $accommodation->price;
        $accommodation->availability = $request->availability ? $request->availability : $accommodation->availability;
        $accommodation->save();

        return response()->json('Successfully updated');

    }

    public function deleteAccommodation(Request $request) {
        $accommodation = Accommodation::find($request->id);
        if($accommodation) {
            $accommodation->delete();
            $accommodation->location()->delete();
            return response()->json('Successfully deleted');
        }
    }

    public function filterAccommodation(Request $request) {
        if($request->rating) {
            return Accommodation::where('rating', $request->rating)
            ->with('location')
            ->get();
        }
        if($request->city) {
            $accommodations = Accommodation::with(['location' => function($q) use($request) {
                $q->where('city', $request->city);
            }])
            ->get()
            ->toArray();

            $data = [];
            foreach($accommodations as $accommodation) {
                if($accommodation['location'] != null) {
                    $data [] = $accommodation;
                }
            }

            return response()->json($data);
        }

        if($request->reputation_badge) {
            return Accommodation::where('reputation_badge', $request->reputation_badge)
            ->with('location')
            ->get();
        }

        if($request->availability) {
            return Accommodation::where('availability', $request->availability)
            ->with('location')
            ->get();
        }
        if($request->category) {
            return Accommodation::where('category', $request->category)
            ->with('location')
            ->get();
        }

        if($request->rating && $request->city && $request->reputation_badge && $request->availability && $request->category) {
            $accommodations = Accommodation::
            where('rating', $request->rating)
            ->where('reputation_badge', $request->reputation_badge)
            ->where('availability', $request->availability)
            ->where('category', $request->category)
            ->with(['location' => function($q) use($request) {
                $q->where('city', $request->city);
            }])
            ->get()
            ->toArray();

            $data = [];
            foreach($accommodations as $accommodation) {
                if($accommodation['location'] != null) {
                    $data [] = $accommodation;
                }
            }

            return response()->json($data);
        }


    }

}
