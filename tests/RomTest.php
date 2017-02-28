<?php

use ALttP\Rom;

class RomTest extends TestCase {
	const UNCLE_TEXT_0_ADDRESS = 0x102943;

	public function setUp() {
		parent::setUp();
		$this->rom = new Rom;
	}

	public function tearDown() {
		parent::tearDown();
		unset($this->rom);
	}

	public function testCheckMD5WithNoBaseFile() {
		$this->assertFalse($this->rom->checkMD5());
	}

	public function testSetHeartBeepSpeedOff() {
		$this->rom->setHeartBeepSpeed('off');

		$this->assertEquals(0x00, $this->rom->read(0x180033));
	}

	public function testSetHeartBeepSpeedNormal() {
		$this->rom->setHeartBeepSpeed('normal');

		$this->assertEquals(0x20, $this->rom->read(0x180033));
	}

	public function testSetHeartBeepSpeedHalf() {
		$this->rom->setHeartBeepSpeed('half');

		$this->assertEquals(0x40, $this->rom->read(0x180033));
	}

	public function testSetHeartBeepSpeedQuarter() {
		$this->rom->setHeartBeepSpeed('quarter');

		$this->assertEquals(0x80, $this->rom->read(0x180033));
	}

	public function testSetHeartBeepSpeedUnknownSetsNormal() {
		$this->rom->setHeartBeepSpeed('testing');

		$this->assertEquals(0x20, $this->rom->read(0x180033));
	}

	public function testSetRupoor() {
		$this->rom->setRupoorValue(40);

		$this->assertEquals([0x28, 0x00], $this->rom->read(0x180036, 2));
	}

	public function testSetRupoorLarge() {
		$this->rom->setRupoorValue(999);

		$this->assertEquals([0xE7, 0x03], $this->rom->read(0x180036, 2));
	}

	public function testSetMaxArrows() {
		$this->rom->setMaxArrows(40);

		$this->assertEquals(40, $this->rom->read(0x180035));
	}

	public function testSetMaxBombs() {
		$this->rom->setMaxBombs(40);

		$this->assertEquals(40, $this->rom->read(0x180034));
	}

	public function testSetCapacityUpgradeFills() {
		$this->rom->setCapacityUpgradeFills([1, 2, 0, 0, 20]);

		$this->assertEquals([1, 2, 0, 0], $this->rom->read(0x180080, 4));
	}

	public function testSetUncleText() {
		$this->rom->setUncleText(0x02);

		$this->assertEquals(0x02, $this->rom->read(0x180040));
	}

	public function testSetExtenedUncleText32() {
		$this->rom->setUncleText(32);

		$converted = [0, 165, 0, 200, 0, 160, 0, 160, 0, 160, 0, 255, 0, 187, 0, 190, 0, 185, 0, 174, 0, 174, 117, 0,
			187, 0, 174, 0, 192, 0, 170, 0, 187, 0, 173, 0, 255, 0, 175, 0, 184, 0, 187, 0, 255, 0, 210, 0, 211, 118, 0,
			194, 0, 184, 0, 190, 0, 216, 0, 187, 0, 174, 0, 255, 0, 171, 0, 184, 0, 183, 0, 174, 0, 173, 127, 127];

		$this->assertEquals($converted, $this->rom->read(static::UNCLE_TEXT_0_ADDRESS, 76));
	}

	public function testSetUncleTextCustom() {
		$this->rom->setUncleTextCustom("1234567890abcd\nline2 specials\n ?!,-.~'");

		$converted = [0, 161, 0, 162, 0, 163, 0, 164, 0, 165, 0, 166, 0, 167, 0, 168, 0, 169, 0, 160, 0, 170, 0, 171, 0,
			172, 0, 173, 117, 0, 181, 0, 178, 0, 183, 0, 174, 0, 162, 0, 255, 0, 188, 0, 185, 0, 174, 0, 172, 0, 178, 0,
			170, 0, 181, 0, 188, 118, 0, 255, 0, 198, 0, 199, 0, 200, 0, 201, 0, 205, 0, 206, 0, 216, 127, 127];

		$this->assertEquals($converted, $this->rom->read(static::UNCLE_TEXT_0_ADDRESS, 76));
	}

	public function testSetKingsReturnCredits() {
		$this->rom->setKingsReturnCredits("this is a test");

		$this->assertEquals([159, 159, 159, 159, 45, 33, 34, 44, 159, 34, 44, 159, 26, 159, 45, 30, 44, 45,
			159, 159, 159, 159], $this->rom->read(0x76928, 22));
	}

	public function testSetSanctuaryCredits() {
		$this->rom->setSanctuaryCredits("this is a test");

		$this->assertEquals([159, 45, 33, 34, 44, 159, 34, 44, 159, 26, 159, 45, 30, 44, 45, 159],
			$this->rom->read(0x76964, 16));
	}

	public function testSetKakarikoTownCredits() {
		$this->rom->setKakarikoTownCredits("this is a test");

		$this->assertEquals([159, 159, 159, 159, 45, 33, 34, 44, 159, 34, 44, 159, 26, 159, 45, 30, 44, 45,
			159, 159, 159, 159, 159], $this->rom->read(0x76997, 23));
	}

	public function testSetDesertPalaceCredits() {
		$this->rom->setDesertPalaceCredits("this is a test");

		$this->assertEquals([159, 159, 159, 159, 159, 45, 33, 34, 44, 159, 34, 44, 159, 26, 159, 45, 30, 44, 45,
			159, 159, 159, 159, 159], $this->rom->read(0x769D4, 24));
	}

	public function testSetMountainTowerCredits() {
		$this->rom->setMountainTowerCredits("this is a test");

		$this->assertEquals([159, 159, 159, 159, 159, 45, 33, 34, 44, 159, 34, 44, 159, 26, 159, 45, 30, 44, 45,
			159, 159, 159, 159, 159], $this->rom->read(0x76A12, 24));
	}

	public function testSetLinksHouseCredits() {
		$this->rom->setLinksHouseCredits("this is a test");

		$this->assertEquals([159, 159, 45, 33, 34, 44, 159, 34, 44, 159, 26, 159, 45, 30, 44, 45,
			159, 159, 159], $this->rom->read(0x76A52, 19));
	}

	public function testSetZoraCredits() {
		$this->rom->setZoraCredits("this is a test");

		$this->assertEquals([159, 159, 159, 45, 33, 34, 44, 159, 34, 44, 159, 26, 159, 45, 30, 44, 45,
			159, 159, 159], $this->rom->read(0x76A85, 20));
	}

	public function testSetMagicShopCredits() {
		$this->rom->setMagicShopCredits("this is a test");

		$this->assertEquals([159, 159, 159, 159, 45, 33, 34, 44, 159, 34, 44, 159, 26, 159, 45, 30, 44, 45,
			159, 159, 159, 159, 159], $this->rom->read(0x76AC5, 23));
	}

	public function testSetWoodsmansHutCredits() {
		$this->rom->setWoodsmansHutCredits("this is a test");

		$this->assertEquals([159, 45, 33, 34, 44, 159, 34, 44, 159, 26, 159, 45, 30, 44, 45, 159],
			$this->rom->read(0x76AFC, 16));
	}

	public function testSetFluteBoyCredits() {
		$this->rom->setFluteBoyCredits("this is a test");

		$this->assertEquals([159, 159, 159, 159, 45, 33, 34, 44, 159, 34, 44, 159, 26, 159, 45, 30, 44, 45,
			159, 159, 159, 159, 159], $this->rom->read(0x76B34, 23));
	}

	public function testSetWishingWellCredits() {
		$this->rom->setWishingWellCredits("this is a test");

		$this->assertEquals([159, 159, 159, 159, 45, 33, 34, 44, 159, 34, 44, 159, 26, 159, 45, 30, 44, 45,
			159, 159, 159, 159, 159], $this->rom->read(0x76B71, 23));
	}


	public function testSetSwordsmithsCredits() {
		$this->rom->setSwordsmithsCredits("this is a test");

		$this->assertEquals([159, 159, 159, 159, 45, 33, 34, 44, 159, 34, 44, 159, 26, 159, 45, 30, 44, 45,
			159, 159, 159, 159, 159], $this->rom->read(0x76BAC, 23));
	}

	public function testSetBugCatchingKidCredits() {
		$this->rom->setBugCatchingKidCredits("this is a test");

		$this->assertEquals([159, 159, 159, 45, 33, 34, 44, 159, 34, 44, 159, 26, 159, 45, 30, 44, 45,
			159, 159, 159], $this->rom->read(0x76BDF, 20));
	}

	public function testSetDeathMountainCredits() {
		$this->rom->setDeathMountainCredits("this is a test");

		$this->assertEquals([159, 45, 33, 34, 44, 159, 34, 44, 159, 26, 159, 45, 30, 44, 45, 159],
			$this->rom->read(0x76C19, 16));
	}

	public function testSetLostWoodsCredits() {
		$this->rom->setLostWoodsCredits("this is a test");

		$this->assertEquals([159, 45, 33, 34, 44, 159, 34, 44, 159, 26, 159, 45, 30, 44, 45, 159],
			$this->rom->read(0x76C51, 16));
	}

	public function testSetAltarCredits() {
		$this->rom->setAltarCredits("this is a test");

		$this->assertEquals([159, 159, 159, 45, 33, 34, 44, 159, 34, 44, 159, 26, 159, 45, 30, 44, 45,
			159, 159, 159], $this->rom->read(0x76C81, 20));
	}

	public function testSetDebugModeOn() {
		$this->rom->setDebugMode(true);

		$this->assertEquals([[0xEA, 0xEA],[0xEA, 0xEA]], [$this->rom->read(0x65B88, 2), $this->rom->read(0x65B91, 2)]);
	}

	public function testSetDebugModeOff() {
		$this->rom->setDebugMode(false);

		$this->assertEquals([[0xF0, 0x21],[0xD0, 0x18]], [$this->rom->read(0x65B88, 2), $this->rom->read(0x65B91, 2)]);
	}

	public function testSetSRAMTraceOn() {
		$this->rom->setSRAMTrace(true);

		$this->assertEquals(0x01, $this->rom->read(0x180030));
	}

	public function testSetSRAMTraceOff() {
		$this->rom->setSRAMTrace(false);

		$this->assertEquals(0x00, $this->rom->read(0x180030));
	}

	public function testSetRandomizerSeedTypeGlitched() {
		$this->rom->setRandomizerSeedType('Glitched');

		$this->assertEquals(0x01, $this->rom->read(0x180210));
	}

	public function testSetRandomizerSeedTypeNormal() {
		$this->rom->setRandomizerSeedType('NoMajorGlitches');

		$this->assertEquals(0x00, $this->rom->read(0x180210));
	}

	public function testSetRandomizerSeedTypeDefaultsToNMG() {
		$this->rom->setRandomizerSeedType('badType');

		$this->assertEquals(0x00, $this->rom->read(0x180210));
	}

	public function testSetRandomizerSeedTypeOff() {
		$this->rom->setRandomizerSeedType('off');

		$this->assertEquals(0xFF, $this->rom->read(0x180210));
	}

	public function testSetGameTypePlandomizer() {
		$this->rom->setGameType('Plandomizer');

		$this->assertEquals(0x01, $this->rom->read(0x180211));
	}

	public function testSeGameTypeRandomizer() {
		$this->rom->setGameType('Randomizer');

		$this->assertEquals(0x00, $this->rom->read(0x180211));
	}

	public function testSeGameTypeDefaultsToRandomizer() {
		$this->rom->setGameType('badType');

		$this->assertEquals(0x00, $this->rom->read(0x180211));
	}

	public function testSeGameTypeOther() {
		$this->rom->setGameType('other');

		$this->assertEquals(0xFF, $this->rom->read(0x180211));
	}

	public function testSetHardMode2ChangesCapeMagicUsage() {
		$this->rom->setHardMode(2);

		$this->assertEquals([0x01, 0x01, 0x01], $this->rom->read(0x3ADA7, 3));
	}

	public function testSetHardMode1ChangesCapeMagicUsage() {
		$this->rom->setHardMode(1);

		$this->assertEquals([0x02, 0x02, 0x02], $this->rom->read(0x3ADA7, 3));
	}

	public function testSetHardMode0ChangesCapeMagicUsage() {
		$this->rom->setHardMode(0);

		$this->assertEquals([0x04, 0x08, 0x10], $this->rom->read(0x3ADA7, 3));
	}

	public function testSetHardMode2ChangesBubbleTransform() {
		$this->rom->setHardMode(2);

		$this->assertEquals(0x79, $this->rom->read(0x36DD0));
	}

	public function testSetHardMode1ChangesBubbleTransform() {
		$this->rom->setHardMode(1);

		$this->assertEquals(0x79, $this->rom->read(0x36DD0));
	}

	public function testSetHardMode0ChangesBubbleTransform() {
		$this->rom->setHardMode(0);

		$this->assertEquals(0xE3, $this->rom->read(0x36DD0));
	}

	public function testSetSmithyQuickItemGiveOn() {
		$this->rom->setSmithyQuickItemGive(true);

		$this->assertEquals(0x01, $this->rom->read(0x180029));
	}

	public function testSetSmithyQuickItemGiveOff() {
		$this->rom->setSmithyQuickItemGive(false);

		$this->assertEquals(0x00, $this->rom->read(0x180029));
	}


	public function testSetPyramidFairyChestsOn() {
		$this->rom->setPyramidFairyChests(true);

		$this->assertEquals([0xB1, 0xC6, 0xF9, 0xC9, 0xC6, 0xF9], $this->rom->read(0x1FC16, 6));
	}

	public function testSetPyramidFairyChestsOff() {
		$this->rom->setPyramidFairyChests(false);

		$this->assertEquals([0xA8, 0xB8, 0x3D, 0xD0, 0xB8, 0x3D], $this->rom->read(0x1FC16, 6));
	}

	public function testSetOpenModeOn() {
		$this->rom->setOpenMode(true);

		$this->assertEquals(0x01, $this->rom->read(0x180032));
	}

	public function testSetOpenModeOff() {
		$this->rom->setOpenMode(false);

		$this->assertEquals(0x00, $this->rom->read(0x180032));
	}

	public function testSetSewersLampConeOn() {
		$this->rom->setSewersLampCone(true);

		$this->assertEquals(0x01, $this->rom->read(0x180038));
	}

	public function testSetSewersLampConeOff() {
		$this->rom->setSewersLampCone(false);

		$this->assertEquals(0x00, $this->rom->read(0x180038));
	}

	public function testSetLightWorldLampConeOn() {
		$this->rom->setLightWorldLampCone(true);

		$this->assertEquals(0x01, $this->rom->read(0x180039));
	}

	public function testSetLightWorldLampConeOff() {
		$this->rom->setLightWorldLampCone(false);

		$this->assertEquals(0x00, $this->rom->read(0x180039));
	}

	public function testSetDarkWorldLampConeOn() {
		$this->rom->setDarkWorldLampCone(true);

		$this->assertEquals(0x01, $this->rom->read(0x18003A));
	}

	public function testSetDarkWorldLampConeOff() {
		$this->rom->setDarkWorldLampCone(false);

		$this->assertEquals(0x00, $this->rom->read(0x18003A));
	}

	public function testSkipZeldaSwordCheckOn() {
		$this->rom->skipZeldaSwordCheck(true);

		$this->assertEquals(0x05, $this->rom->read(0x2EBD4));
	}

	public function testSkipZeldaSwordCheckOff() {
		$this->rom->skipZeldaSwordCheck(false);

		$this->assertEquals(0x02, $this->rom->read(0x2EBD4));
	}


	public function testSetMirrorlessSaveAneQuitToLightWorldOn() {
		$this->rom->setMirrorlessSaveAneQuitToLightWorld(true);

		$this->assertEquals(0x01, $this->rom->read(0x1800A0));
	}

	public function testSetMirrorlessSaveAneQuitToLightWorldOff() {
		$this->rom->setMirrorlessSaveAneQuitToLightWorld(false);

		$this->assertEquals(0x00, $this->rom->read(0x1800A0));
	}

	public function testSetSwampWaterLevelOn() {
		$this->rom->setSwampWaterLevel(true);

		$this->assertEquals(0x01, $this->rom->read(0x1800A1));
	}

	public function testSetSwampWaterLevelOff() {
		$this->rom->setSwampWaterLevel(false);

		$this->assertEquals(0x00, $this->rom->read(0x1800A1));
	}

	public function testSetPreAgahnimDarkWorldDeathInDungeonOn() {
		$this->rom->setPreAgahnimDarkWorldDeathInDungeon(true);

		$this->assertEquals(0x01, $this->rom->read(0x1800A2));
	}

	public function testSetPreAgahnimDarkWorldDeathInDungeonOff() {
		$this->rom->setPreAgahnimDarkWorldDeathInDungeon(false);

		$this->assertEquals(0x00, $this->rom->read(0x1800A2));
	}

	public function testSetSeedString() {
		$this->rom->setSeedString('123456789012345678901');

		$this->assertEquals([49,50,51,52,53,54,55,56,57,48,49,50,51,52,53,54,55,56,57,48,49], $this->rom->read(0x7FC0, 21));
	}

	public function testSetSeedStringNotLongerThan21Chars() {
		$this->rom->setSeedString('aaaaaaaaaaaaaaaaaaaaaaaaa');

		$this->assertEquals([97,97,97,97,97,97,97,97,97,97,97,97,97,97,97,97,97,97,97,97,97], $this->rom->read(0x7FC0, 25));
	}

}
