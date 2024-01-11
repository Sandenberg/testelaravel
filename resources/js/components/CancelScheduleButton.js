import React from 'react';
import axios from 'axios';

const CancelScheduleButton = ({ scheduledNotificationId }) => {
  const handleCancel = async () => {
    try {
      await axios.post(`/cancel-schedule/${scheduledNotificationId}`);

      console.log('Schedule canceled successfully');
    } catch (error) {
      console.error('Error during cancellation:', error.message);
    }
  };

  return <button onClick={handleCancel}>Cancel Schedule</button>;
};

export default CancelScheduleButton;