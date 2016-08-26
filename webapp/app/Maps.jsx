import React from 'react';

import GoogleMap from 'google-map-react';
const API_KEY = 'AIzaSyC2CY6tmBR88gS6cw_v6hf7JM2CSKz6ZgA';

export default class Maps extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      data: null,
    }
  }
  componentWillReceiveProps(nextProps) {
    console.log("Maps Component - componentWillReceiveProps, gameId:", nextProps.gameId, "location:", nextProps.location);
    var that = this;
    fetch(`http://islandofthedead.com/game/${nextProps.gameId}`)
    .then(function(response) {
      return response.json();
    })
    .then(function(jsonResponse) {
      var data = jsonResponse;
      that.setState({
        data: data
      });
    });
  }

  render() {
    console.log("gameID", this.props.gameId);
    return (
       <GoogleMap
         bootstrapURLKeys={{
           key: API_KEY,
           language: 'nl'
         }}
        center={this.props.location}
        defaultCenter={this.props.defaultCenter}
        defaultZoom={this.props.zoom}
        >
      </GoogleMap>
    );
  }
}

Maps.defaultProps = {
  gameId: null,
  location: {lat: 52.373486, lng: 5.637864},
  defaultCenter: {lat: 52.373486, lng: 5.637864},
  zoom: 18,
};