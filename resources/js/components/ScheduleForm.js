import React, { useState } from 'react';
import axios from 'axios';

const ScheduleForm = () => {
  const [scheduledDatetime, setScheduledDatetime] = useState('');
  const [message, setMessage] = useState('');
  const [contactId, setContactId] = useState('');
  const [userId, setUserId] = useState('');
  const [isRead, setIsRead] = useState(false);

  const handleSchedule = async () => {
    try {
      await axios.post('/schedule-mass-notification', {
        scheduled_datetime: scheduledDatetime,
        message,
        contact_id: contactId,
        user_id: userId,
        is_read: isRead,
        created_at: new Date().toISOString(),
        updated_at: new Date().toISOString(),
      });

      console.log('Mass notification scheduled successfully');
    } catch (error) {
      console.error('Error during scheduling:', error.message);
    }
  };

  return (
    <div>
      <input
        type="text"
        placeholder="Scheduled Datetime"
        value={scheduledDatetime}
        onChange={(e) => setScheduledDatetime(e.target.value)}
      />
      <input
        type="text"
        placeholder="Message"
        value={message}
        onChange={(e) => setMessage(e.target.value)}
      />
      <input
        type="text"
        placeholder="Contact ID"
        value={contactId}
        onChange={(e) => setContactId(e.target.value)}
      />
      <input
        type="text"
        placeholder="User ID"
        value={userId}
        onChange={(e) => setUserId(e.target.value)}
      />
      <label>
        Is Read:
        <input
          type="checkbox"
          checked={isRead}
          onChange={() => setIsRead(!isRead)}
        />
      </label>
      <button onClick={handleSchedule}>Schedule</button>
    </div>
  );
};

export default ScheduleForm;