-- Appointment Booking System Database Schema
196	-- Generated for GitHub Repository
197	
198	SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
199	START TRANSACTION;
200	SET time_zone = "+00:00";
201	
202	/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
203	/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
204	/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
205	/*!40101 SET NAMES utf8mb4 */;
206	
207	--
208	-- Database: `appointment_booking_system`
209	--
210	
211	-- --------------------------------------------------------
212	
213	--
214	-- Table structure for table `admin`
215	--
216	
217	CREATE TABLE `admin` (
218	  `id` int(11) NOT NULL,
219	  `username` varchar(50) NOT NULL,
220	  `password` varchar(255) NOT NULL,
221	  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
222	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
223	
224	-- --------------------------------------------------------
225	
226	--
227	-- Table structure for table `appointments`
228	--
229	
230	CREATE TABLE `appointments` (
231	  `id` int(11) NOT NULL,
232	  `patient_id` int(11) NOT NULL,
233	  `doctor_id` int(11) NOT NULL,
234	  `appointment_date` date NOT NULL,
235	  `appointment_time` time NOT NULL,
236	  `status` enum('Pending','Approved','Cancelled') DEFAULT 'Pending',
237	  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
238	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
239	
240	-- --------------------------------------------------------
241	
242	--
243	-- Table structure for table `doctors`
244	--
245	
246	CREATE TABLE `doctors` (
247	  `id` int(11) NOT NULL,
248	  `name` varchar(100) NOT NULL,
249	  `specialization` varchar(100) NOT NULL,
250	  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
251	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
252	
253	-- --------------------------------------------------------
254	
255	--
256	-- Table structure for table `patients`
257	--
258	
259	CREATE TABLE `patients` (
260	  `id` int(11) NOT NULL,
261	  `name` varchar(100) NOT NULL,
262	  `email` varchar(100) NOT NULL,
263	  `password` varchar(255) NOT NULL,
264	  `phone` varchar(20) NOT NULL,
265	  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
266	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
267	
268	--
269	-- Indexes for dumped tables
270	--
271	
272	--
273	-- Indexes for table `admin`
274	--
275	ALTER TABLE `admin`
276	  ADD PRIMARY KEY (`id`),
277	  ADD UNIQUE KEY `username` (`username`);
278	
279	--
280	-- Indexes for table `appointments`
281	--
282	ALTER TABLE `appointments`
283	  ADD PRIMARY KEY (`id`),
284	  ADD KEY `idx_appointment_date` (`appointment_date`),
285	  ADD KEY `idx_appointment_patient` (`patient_id`),
286	  ADD KEY `idx_appointment_doctor` (`doctor_id`),
287	  ADD KEY `idx_appointment_status` (`status`);
288	
289	--
290	-- Indexes for table `doctors`
291	--
292	ALTER TABLE `doctors`
293	  ADD PRIMARY KEY (`id`),
294	  ADD KEY `idx_doctor_name` (`name`);
295	
296	--
297	-- Indexes for table `patients`
298	--
299	ALTER TABLE `patients`
300	  ADD PRIMARY KEY (`id`),
301	  ADD UNIQUE KEY `email` (`email`),
302	  ADD KEY `idx_patient_email` (`email`),
303	  ADD KEY `idx_patient_created` (`created_at`);
304	
305	--
306	-- AUTO_INCREMENT for dumped tables
307	--
308	
309	--
310	-- AUTO_INCREMENT for table `admin`
311	--
312	ALTER TABLE `admin`
313	  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
314	
315	--
316	-- AUTO_INCREMENT for table `appointments`
317	--
318	ALTER TABLE `appointments`
319	  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
320	
321	--
322	-- AUTO_INCREMENT for table `doctors`
323	--
324	ALTER TABLE `doctors`
325	  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
326	
327	--
328	-- AUTO_INCREMENT for table `patients`
329	--
330	ALTER TABLE `patients`
331	  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
332	
333	--
334	-- Constraints for dumped tables
335	--
336	
337	--
338	-- Constraints for table `appointments`
339	--
340	ALTER TABLE `appointments`
341	  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
342	  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;
343	COMMIT;
344	
345	/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
346	/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
347	/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
348	
