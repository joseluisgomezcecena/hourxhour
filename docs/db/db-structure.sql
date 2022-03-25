

CREATE TABLE `plants` (
  `plant_id` int(11) NOT NULL AUTO_INCREMENT,
  `plant_name` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `plant_use_password` tinyint(1) DEFAULT NULL,
  `plant_password` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `plant_active` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`plant_id`),
  UNIQUE KEY `index_unique_plant_name` (`plant_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE TABLE `sites` (
  `site_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `plant_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`site_id`),
  UNIQUE KEY `unique_index_site_name` (`site_name`),
  KEY `fk_sites_plant_id_plants_plant_id_idx` (`plant_id`),
  CONSTRAINT `fk_sites_plant_id_plants_plant_id` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`plant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;


CREATE TABLE `assets` (
  `asset_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `asset_name` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `asset_control_number` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `asset_work_center` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `asset_active` tinyint(1) NOT NULL DEFAULT 1,
  `asset_is_machine` tinyint(1) NOT NULL DEFAULT 0,
  `asset_is_station` tinyint(1) NOT NULL DEFAULT 0,
  `asset_is_pom` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`asset_id`),
  KEY `fk_assets_site_id_sites_site_id_idx` (`site_id`),
  CONSTRAINT `fk_assets_site_id_sites_site_id` FOREIGN KEY (`site_id`) REFERENCES `sites` (`site_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=282 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;



CREATE TABLE `shifts` (
  `shift_id` int(11) NOT NULL AUTO_INCREMENT,
  `shift_name` varchar(45) COLLATE utf8mb4_spanish_ci NOT NULL,
  `shift_start_time` time DEFAULT NULL,
  `shift_end_time` time DEFAULT NULL,
  PRIMARY KEY (`shift_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE TABLE `production_plans` (
  `plan_id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `shift_id` int(11) DEFAULT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`plan_id`),
  KEY `fk_production_plan_asset_id_assets_asset_id_idx` (`asset_id`),
  KEY `fk_production_plans_shift_id_shifts_shift_id_idx` (`shift_id`),
  CONSTRAINT `fk_production_plan_asset_id_assets_asset_id` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`asset_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_production_plans_shift_id_shifts_shift_id` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`shift_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE TABLE `plan_by_hours` (
  `plan_by_hour_id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_id` int(11) NOT NULL,
  `time` time NOT NULL,
  `planned` int(11) DEFAULT NULL,
  `planned_head_cout` int(11) DEFAULT NULL,
  `workorder` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `part_number` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `completed` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`plan_by_hour_id`),
  KEY `fk_production_plan_plan_id_plan_by_hour_idx` (`plan_id`),
  CONSTRAINT `fk_production_plan_plan_id_plan_by_hour` FOREIGN KEY (`plan_id`) REFERENCES `production_plans` (`plan_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
