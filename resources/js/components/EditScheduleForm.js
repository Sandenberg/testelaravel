import React, { useState } from 'react';
import axios from 'axios';

const EditScheduleForm = ({ scheduledNotificationId }) => {
  const [newMessage, setNewMessage] = useState('');

  const handleEdit = async () => {
    try {
      await axios.post(`/edit-schedule/${scheduledNotificationId}`, {
        message: newMessage,
        scheduled_at: new Date().toISOString(),
        contact_id: 1,
        user_id: 1,
        is_read: false,
        created_at: new Date().toISOString(),
        updated_at: new Date().toISOString(),
      });

      console.log('Schedule edited successfully');
    } catch (error) {
      console.error('Error during editing:', error.message);
    }
  };

  return (
    <div>
      <input
        type="text"
        placeholder="New Message"
        value={newMessage}
        onChange={(e) => setNewMessage(e.target.value)}
      />
      <button onClick={handleEdit}>Edit Schedule</button>
    </div>
  );
};

export default EditScheduleForm;