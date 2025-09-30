<script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "ParkingFacility",
      "name": "Aero Parking",
      "description": "{{ __('messages.meta.description') }}",
  "url": "{{ url('/') }}",
  "telephone": "+381 69 445 4255",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Put za aerodrom bb",
    "addressLocality": "Beograd",
    "postalCode": "11271",
    "addressCountry": "RS"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 44.804032,
    "longitude": 20.300839
  },
  "image": "{{ asset('img/android-chrome-512x512.webp') }}",
  "openingHoursSpecification": [{
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": [
      "Monday",
      "Tuesday",
      "Wednesday",
      "Thursday",
      "Friday",
      "Saturday",
      "Sunday"
    ],
    "opens": "00:00",
    "closes": "23:59"
  }],
  "sameAs": [
    "https://www.facebook.com/parking.aero",
    "https://www.instagram.com/parking.aero"
  ]
}
</script>
