import React from 'react';
import {Alert, Button, View} from 'react-native';
import axios from 'axios';
import * as Location from 'expo-location';

const api = axios.create({
  baseURL: 'https://your-domain.test/api/v1',
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
});

async function getCurrentLocation() {
  const {status} = await Location.requestForegroundPermissionsAsync();
  if (status !== 'granted') {
    throw new Error('Location permission denied');
  }

  return Location.getCurrentPositionAsync({accuracy: Location.Accuracy.High});
}

async function sendPanicReport() {
  const location = await getCurrentLocation();

  await api.post('/hotline/panic', {
    latitude: location.coords.latitude,
    longitude: location.coords.longitude,
    description: 'Panic button activated from mobile app',
  });
}

export default function PanicButtonScreen() {
  const handlePress = async () => {
    try {
      await sendPanicReport();
      Alert.alert('Berhasil', 'Panic report terkirim');
    } catch (error) {
      Alert.alert('Gagal', 'Tidak dapat mengirim panic report');
    }
  };

  return (
    <View style={{flex: 1, justifyContent: 'center', padding: 24}}>
      <Button title="PANIC" color="#d11" onPress={handlePress} />
    </View>
  );
}
