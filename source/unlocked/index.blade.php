<!doctype html>
<html class="staticrypt-html">
<head>
    <meta charset="utf-8">
    <title>Protected Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- do not cache this page -->
    <meta http-equiv="cache-control" content="max-age=0"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="expires" content="0"/>
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT"/>
    <meta http-equiv="pragma" content="no-cache"/>

    <style>
        .staticrypt-hr {
            margin-top: 20px;
            margin-bottom: 20px;
            border: 0;
            border-top: 1px solid #eee;
        }

        .staticrypt-page {
            width: 360px;
            padding: 8% 0 0;
            margin: auto;
            box-sizing: border-box;
        }

        .staticrypt-form {
            position: relative;
            z-index: 1;
            background: #FFFFFF;
            max-width: 360px;
            margin: 0 auto 100px;
            padding: 45px;
            text-align: center;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }

        .staticrypt-form input[type="password"] {
            outline: 0;
            background: #f2f2f2;
            width: 100%;
            border: 0;
            margin: 0 0 15px;
            padding: 15px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .staticrypt-form .staticrypt-decrypt-button {
            text-transform: uppercase;
            outline: 0;
            background: #4CAF50;
            width: 100%;
            border: 0;
            padding: 15px;
            color: #FFFFFF;
            font-size: 14px;
            cursor: pointer;
        }

        .staticrypt-form .staticrypt-decrypt-button:hover, .staticrypt-form .staticrypt-decrypt-button:active, .staticrypt-form .staticrypt-decrypt-button:focus {
            background: #43A047;
        }

        .staticrypt-html {
            height: 100%;
        }

        .staticrypt-body {
            margin-bottom: 1em;
            background: #302E6F; /* fallback for old browsers */
            font-family: "Arial", sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .staticrypt-instructions {
            margin-top: -1em;
            margin-bottom: 1em;
        }

        .staticrypt-title {
            font-size: 1.5em;
        }

        .staticrypt-footer {
            position: fixed;
            height: 20px;
            font-size: 16px;
            padding: 2px;
            bottom: 0;
            left: 0;
            right: 0;
            margin-bottom: 0;
        }

        .staticrypt-footer p {
            margin: 2px;
            text-align: center;
            float: right;
        }

        .staticrypt-footer a {
            text-decoration: none;
        }

        label.staticrypt-remember {
            display: flex;
            align-items: center;
            margin-bottom: 1em;
        }

        .staticrypt-remember input[type=checkbox] {
            transform: scale(1.5);
            margin-right: 1em;
        }

        .hidden {
            display: none !important;
        }
    </style>
</head>

<body class="staticrypt-body">
<div class="staticrypt-page">
    <div class="staticrypt-form">
        <div class="staticrypt-instructions">
            <p class="staticrypt-title">Protected Page</p>
            <p></p>
        </div>

        <hr class="staticrypt-hr">

        <form id="staticrypt-form" action="#" method="post">
            <input id="staticrypt-password"
                   type="password"
                   name="password"
                   placeholder="Passphrase"
                   autofocus/>

            <label id="staticrypt-remember-label" class="staticrypt-remember hidden">
                <input id="staticrypt-remember"
                       type="checkbox"
                       name="remember"/>
                Remember me
            </label>

            <input type="submit" class="staticrypt-decrypt-button" value="Unlock"/>
        </form>
    </div>

</div>
<footer class="staticrypt-footer">
    <p class="pull-right">Created with <a href="https://robinmoisson.github.io/staticrypt">StatiCrypt</a></p>
</footer>


<script>/**
 * Crypto JS 3.1.9-1
 * Copied as is from https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js
 */

;(function (root, factory) {
    if (typeof exports === "object") {
        // CommonJS
        module.exports = exports = factory();
    }
    else if (typeof define === "function" && define.amd) {
        // AMD
        define([], factory);
    }
    else {
        // Global (browser)
        root.CryptoJS = factory();
    }
}(this, function () {

    /**
     * CryptoJS core components.
     */
    var CryptoJS = CryptoJS || (function (Math, undefined) {
        /*
	     * Local polyfil of Object.create
	     */
        var create = Object.create || (function () {
            function F() {};

            return function (obj) {
                var subtype;

                F.prototype = obj;

                subtype = new F();

                F.prototype = null;

                return subtype;
            };
        }())

        /**
         * CryptoJS namespace.
         */
        var C = {};

        /**
         * Library namespace.
         */
        var C_lib = C.lib = {};

        /**
         * Base object for prototypal inheritance.
         */
        var Base = C_lib.Base = (function () {


            return {
                /**
                 * Creates a new object that inherits from this object.
                 *
                 * @param {Object} overrides Properties to copy into the new object.
                 *
                 * @return {Object} The new object.
                 *
                 * @static
                 *
                 * @example
                 *
                 *     var MyType = CryptoJS.lib.Base.extend({
	             *         field: 'value',
	             *
	             *         method: function () {
	             *         }
	             *     });
                 */
                extend: function (overrides) {
                    // Spawn
                    var subtype = create(this);

                    // Augment
                    if (overrides) {
                        subtype.mixIn(overrides);
                    }

                    // Create default initializer
                    if (!subtype.hasOwnProperty('init') || this.init === subtype.init) {
                        subtype.init = function () {
                            subtype.$super.init.apply(this, arguments);
                        };
                    }

                    // Initializer's prototype is the subtype object
                    subtype.init.prototype = subtype;

                    // Reference supertype
                    subtype.$super = this;

                    return subtype;
                },

                /**
                 * Extends this object and runs the init method.
                 * Arguments to create() will be passed to init().
                 *
                 * @return {Object} The new object.
                 *
                 * @static
                 *
                 * @example
                 *
                 *     var instance = MyType.create();
                 */
                create: function () {
                    var instance = this.extend();
                    instance.init.apply(instance, arguments);

                    return instance;
                },

                /**
                 * Initializes a newly created object.
                 * Override this method to add some logic when your objects are created.
                 *
                 * @example
                 *
                 *     var MyType = CryptoJS.lib.Base.extend({
	             *         init: function () {
	             *             // ...
	             *         }
	             *     });
                 */
                init: function () {
                },

                /**
                 * Copies properties into this object.
                 *
                 * @param {Object} properties The properties to mix in.
                 *
                 * @example
                 *
                 *     MyType.mixIn({
	             *         field: 'value'
	             *     });
                 */
                mixIn: function (properties) {
                    for (var propertyName in properties) {
                        if (properties.hasOwnProperty(propertyName)) {
                            this[propertyName] = properties[propertyName];
                        }
                    }

                    // IE won't copy toString using the loop above
                    if (properties.hasOwnProperty('toString')) {
                        this.toString = properties.toString;
                    }
                },

                /**
                 * Creates a copy of this object.
                 *
                 * @return {Object} The clone.
                 *
                 * @example
                 *
                 *     var clone = instance.clone();
                 */
                clone: function () {
                    return this.init.prototype.extend(this);
                }
            };
        }());

        /**
         * An array of 32-bit words.
         *
         * @property {Array} words The array of 32-bit words.
         * @property {number} sigBytes The number of significant bytes in this word array.
         */
        var WordArray = C_lib.WordArray = Base.extend({
            /**
             * Initializes a newly created word array.
             *
             * @param {Array} words (Optional) An array of 32-bit words.
             * @param {number} sigBytes (Optional) The number of significant bytes in the words.
             *
             * @example
             *
             *     var wordArray = CryptoJS.lib.WordArray.create();
             *     var wordArray = CryptoJS.lib.WordArray.create([0x00010203, 0x04050607]);
             *     var wordArray = CryptoJS.lib.WordArray.create([0x00010203, 0x04050607], 6);
             */
            init: function (words, sigBytes) {
                words = this.words = words || [];

                if (sigBytes != undefined) {
                    this.sigBytes = sigBytes;
                } else {
                    this.sigBytes = words.length * 4;
                }
            },

            /**
             * Converts this word array to a string.
             *
             * @param {Encoder} encoder (Optional) The encoding strategy to use. Default: CryptoJS.enc.Hex
             *
             * @return {string} The stringified word array.
             *
             * @example
             *
             *     var string = wordArray + '';
             *     var string = wordArray.toString();
             *     var string = wordArray.toString(CryptoJS.enc.Utf8);
             */
            toString: function (encoder) {
                return (encoder || Hex).stringify(this);
            },

            /**
             * Concatenates a word array to this word array.
             *
             * @param {WordArray} wordArray The word array to append.
             *
             * @return {WordArray} This word array.
             *
             * @example
             *
             *     wordArray1.concat(wordArray2);
             */
            concat: function (wordArray) {
                // Shortcuts
                var thisWords = this.words;
                var thatWords = wordArray.words;
                var thisSigBytes = this.sigBytes;
                var thatSigBytes = wordArray.sigBytes;

                // Clamp excess bits
                this.clamp();

                // Concat
                if (thisSigBytes % 4) {
                    // Copy one byte at a time
                    for (var i = 0; i < thatSigBytes; i++) {
                        var thatByte = (thatWords[i >>> 2] >>> (24 - (i % 4) * 8)) & 0xff;
                        thisWords[(thisSigBytes + i) >>> 2] |= thatByte << (24 - ((thisSigBytes + i) % 4) * 8);
                    }
                } else {
                    // Copy one word at a time
                    for (var i = 0; i < thatSigBytes; i += 4) {
                        thisWords[(thisSigBytes + i) >>> 2] = thatWords[i >>> 2];
                    }
                }
                this.sigBytes += thatSigBytes;

                // Chainable
                return this;
            },

            /**
             * Removes insignificant bits.
             *
             * @example
             *
             *     wordArray.clamp();
             */
            clamp: function () {
                // Shortcuts
                var words = this.words;
                var sigBytes = this.sigBytes;

                // Clamp
                words[sigBytes >>> 2] &= 0xffffffff << (32 - (sigBytes % 4) * 8);
                words.length = Math.ceil(sigBytes / 4);
            },

            /**
             * Creates a copy of this word array.
             *
             * @return {WordArray} The clone.
             *
             * @example
             *
             *     var clone = wordArray.clone();
             */
            clone: function () {
                var clone = Base.clone.call(this);
                clone.words = this.words.slice(0);

                return clone;
            },

            /**
             * Creates a word array filled with random bytes.
             *
             * @param {number} nBytes The number of random bytes to generate.
             *
             * @return {WordArray} The random word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.lib.WordArray.random(16);
             */
            random: function (nBytes) {
                var words = [];

                var r = (function (m_w) {
                    var m_w = m_w;
                    var m_z = 0x3ade68b1;
                    var mask = 0xffffffff;

                    return function () {
                        m_z = (0x9069 * (m_z & 0xFFFF) + (m_z >> 0x10)) & mask;
                        m_w = (0x4650 * (m_w & 0xFFFF) + (m_w >> 0x10)) & mask;
                        var result = ((m_z << 0x10) + m_w) & mask;
                        result /= 0x100000000;
                        result += 0.5;
                        return result * (Math.random() > .5 ? 1 : -1);
                    }
                });

                for (var i = 0, rcache; i < nBytes; i += 4) {
                    var _r = r((rcache || Math.random()) * 0x100000000);

                    rcache = _r() * 0x3ade67b7;
                    words.push((_r() * 0x100000000) | 0);
                }

                return new WordArray.init(words, nBytes);
            }
        });

        /**
         * Encoder namespace.
         */
        var C_enc = C.enc = {};

        /**
         * Hex encoding strategy.
         */
        var Hex = C_enc.Hex = {
            /**
             * Converts a word array to a hex string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The hex string.
             *
             * @static
             *
             * @example
             *
             *     var hexString = CryptoJS.enc.Hex.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;

                // Convert
                var hexChars = [];
                for (var i = 0; i < sigBytes; i++) {
                    var bite = (words[i >>> 2] >>> (24 - (i % 4) * 8)) & 0xff;
                    hexChars.push((bite >>> 4).toString(16));
                    hexChars.push((bite & 0x0f).toString(16));
                }

                return hexChars.join('');
            },

            /**
             * Converts a hex string to a word array.
             *
             * @param {string} hexStr The hex string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Hex.parse(hexString);
             */
            parse: function (hexStr) {
                // Shortcut
                var hexStrLength = hexStr.length;

                // Convert
                var words = [];
                for (var i = 0; i < hexStrLength; i += 2) {
                    words[i >>> 3] |= parseInt(hexStr.substr(i, 2), 16) << (24 - (i % 8) * 4);
                }

                return new WordArray.init(words, hexStrLength / 2);
            }
        };

        /**
         * Latin1 encoding strategy.
         */
        var Latin1 = C_enc.Latin1 = {
            /**
             * Converts a word array to a Latin1 string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The Latin1 string.
             *
             * @static
             *
             * @example
             *
             *     var latin1String = CryptoJS.enc.Latin1.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;

                // Convert
                var latin1Chars = [];
                for (var i = 0; i < sigBytes; i++) {
                    var bite = (words[i >>> 2] >>> (24 - (i % 4) * 8)) & 0xff;
                    latin1Chars.push(String.fromCharCode(bite));
                }

                return latin1Chars.join('');
            },

            /**
             * Converts a Latin1 string to a word array.
             *
             * @param {string} latin1Str The Latin1 string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Latin1.parse(latin1String);
             */
            parse: function (latin1Str) {
                // Shortcut
                var latin1StrLength = latin1Str.length;

                // Convert
                var words = [];
                for (var i = 0; i < latin1StrLength; i++) {
                    words[i >>> 2] |= (latin1Str.charCodeAt(i) & 0xff) << (24 - (i % 4) * 8);
                }

                return new WordArray.init(words, latin1StrLength);
            }
        };

        /**
         * UTF-8 encoding strategy.
         */
        var Utf8 = C_enc.Utf8 = {
            /**
             * Converts a word array to a UTF-8 string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The UTF-8 string.
             *
             * @static
             *
             * @example
             *
             *     var utf8String = CryptoJS.enc.Utf8.stringify(wordArray);
             */
            stringify: function (wordArray) {
                try {
                    return decodeURIComponent(escape(Latin1.stringify(wordArray)));
                } catch (e) {
                    throw new Error('Malformed UTF-8 data');
                }
            },

            /**
             * Converts a UTF-8 string to a word array.
             *
             * @param {string} utf8Str The UTF-8 string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Utf8.parse(utf8String);
             */
            parse: function (utf8Str) {
                return Latin1.parse(unescape(encodeURIComponent(utf8Str)));
            }
        };

        /**
         * Abstract buffered block algorithm template.
         *
         * The property blockSize must be implemented in a concrete subtype.
         *
         * @property {number} _minBufferSize The number of blocks that should be kept unprocessed in the buffer. Default: 0
         */
        var BufferedBlockAlgorithm = C_lib.BufferedBlockAlgorithm = Base.extend({
            /**
             * Resets this block algorithm's data buffer to its initial state.
             *
             * @example
             *
             *     bufferedBlockAlgorithm.reset();
             */
            reset: function () {
                // Initial values
                this._data = new WordArray.init();
                this._nDataBytes = 0;
            },

            /**
             * Adds new data to this block algorithm's buffer.
             *
             * @param {WordArray|string} data The data to append. Strings are converted to a WordArray using UTF-8.
             *
             * @example
             *
             *     bufferedBlockAlgorithm._append('data');
             *     bufferedBlockAlgorithm._append(wordArray);
             */
            _append: function (data) {
                // Convert string to WordArray, else assume WordArray already
                if (typeof data == 'string') {
                    data = Utf8.parse(data);
                }

                // Append
                this._data.concat(data);
                this._nDataBytes += data.sigBytes;
            },

            /**
             * Processes available data blocks.
             *
             * This method invokes _doProcessBlock(offset), which must be implemented by a concrete subtype.
             *
             * @param {boolean} doFlush Whether all blocks and partial blocks should be processed.
             *
             * @return {WordArray} The processed data.
             *
             * @example
             *
             *     var processedData = bufferedBlockAlgorithm._process();
             *     var processedData = bufferedBlockAlgorithm._process(!!'flush');
             */
            _process: function (doFlush) {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;
                var dataSigBytes = data.sigBytes;
                var blockSize = this.blockSize;
                var blockSizeBytes = blockSize * 4;

                // Count blocks ready
                var nBlocksReady = dataSigBytes / blockSizeBytes;
                if (doFlush) {
                    // Round up to include partial blocks
                    nBlocksReady = Math.ceil(nBlocksReady);
                } else {
                    // Round down to include only full blocks,
                    // less the number of blocks that must remain in the buffer
                    nBlocksReady = Math.max((nBlocksReady | 0) - this._minBufferSize, 0);
                }

                // Count words ready
                var nWordsReady = nBlocksReady * blockSize;

                // Count bytes ready
                var nBytesReady = Math.min(nWordsReady * 4, dataSigBytes);

                // Process blocks
                if (nWordsReady) {
                    for (var offset = 0; offset < nWordsReady; offset += blockSize) {
                        // Perform concrete-algorithm logic
                        this._doProcessBlock(dataWords, offset);
                    }

                    // Remove processed words
                    var processedWords = dataWords.splice(0, nWordsReady);
                    data.sigBytes -= nBytesReady;
                }

                // Return processed words
                return new WordArray.init(processedWords, nBytesReady);
            },

            /**
             * Creates a copy of this object.
             *
             * @return {Object} The clone.
             *
             * @example
             *
             *     var clone = bufferedBlockAlgorithm.clone();
             */
            clone: function () {
                var clone = Base.clone.call(this);
                clone._data = this._data.clone();

                return clone;
            },

            _minBufferSize: 0
        });

        /**
         * Abstract hasher template.
         *
         * @property {number} blockSize The number of 32-bit words this hasher operates on. Default: 16 (512 bits)
         */
        var Hasher = C_lib.Hasher = BufferedBlockAlgorithm.extend({
            /**
             * Configuration options.
             */
            cfg: Base.extend(),

            /**
             * Initializes a newly created hasher.
             *
             * @param {Object} cfg (Optional) The configuration options to use for this hash computation.
             *
             * @example
             *
             *     var hasher = CryptoJS.algo.SHA256.create();
             */
            init: function (cfg) {
                // Apply config defaults
                this.cfg = this.cfg.extend(cfg);

                // Set initial values
                this.reset();
            },

            /**
             * Resets this hasher to its initial state.
             *
             * @example
             *
             *     hasher.reset();
             */
            reset: function () {
                // Reset data buffer
                BufferedBlockAlgorithm.reset.call(this);

                // Perform concrete-hasher logic
                this._doReset();
            },

            /**
             * Updates this hasher with a message.
             *
             * @param {WordArray|string} messageUpdate The message to append.
             *
             * @return {Hasher} This hasher.
             *
             * @example
             *
             *     hasher.update('message');
             *     hasher.update(wordArray);
             */
            update: function (messageUpdate) {
                // Append
                this._append(messageUpdate);

                // Update the hash
                this._process();

                // Chainable
                return this;
            },

            /**
             * Finalizes the hash computation.
             * Note that the finalize operation is effectively a destructive, read-once operation.
             *
             * @param {WordArray|string} messageUpdate (Optional) A final message update.
             *
             * @return {WordArray} The hash.
             *
             * @example
             *
             *     var hash = hasher.finalize();
             *     var hash = hasher.finalize('message');
             *     var hash = hasher.finalize(wordArray);
             */
            finalize: function (messageUpdate) {
                // Final message update
                if (messageUpdate) {
                    this._append(messageUpdate);
                }

                // Perform concrete-hasher logic
                var hash = this._doFinalize();

                return hash;
            },

            blockSize: 512/32,

            /**
             * Creates a shortcut function to a hasher's object interface.
             *
             * @param {Hasher} hasher The hasher to create a helper for.
             *
             * @return {Function} The shortcut function.
             *
             * @static
             *
             * @example
             *
             *     var SHA256 = CryptoJS.lib.Hasher._createHelper(CryptoJS.algo.SHA256);
             */
            _createHelper: function (hasher) {
                return function (message, cfg) {
                    return new hasher.init(cfg).finalize(message);
                };
            },

            /**
             * Creates a shortcut function to the HMAC's object interface.
             *
             * @param {Hasher} hasher The hasher to use in this HMAC helper.
             *
             * @return {Function} The shortcut function.
             *
             * @static
             *
             * @example
             *
             *     var HmacSHA256 = CryptoJS.lib.Hasher._createHmacHelper(CryptoJS.algo.SHA256);
             */
            _createHmacHelper: function (hasher) {
                return function (message, key) {
                    return new C_algo.HMAC.init(hasher, key).finalize(message);
                };
            }
        });

        /**
         * Algorithm namespace.
         */
        var C_algo = C.algo = {};

        return C;
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var C_enc = C.enc;

        /**
         * Base64 encoding strategy.
         */
        var Base64 = C_enc.Base64 = {
            /**
             * Converts a word array to a Base64 string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The Base64 string.
             *
             * @static
             *
             * @example
             *
             *     var base64String = CryptoJS.enc.Base64.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;
                var map = this._map;

                // Clamp excess bits
                wordArray.clamp();

                // Convert
                var base64Chars = [];
                for (var i = 0; i < sigBytes; i += 3) {
                    var byte1 = (words[i >>> 2]       >>> (24 - (i % 4) * 8))       & 0xff;
                    var byte2 = (words[(i + 1) >>> 2] >>> (24 - ((i + 1) % 4) * 8)) & 0xff;
                    var byte3 = (words[(i + 2) >>> 2] >>> (24 - ((i + 2) % 4) * 8)) & 0xff;

                    var triplet = (byte1 << 16) | (byte2 << 8) | byte3;

                    for (var j = 0; (j < 4) && (i + j * 0.75 < sigBytes); j++) {
                        base64Chars.push(map.charAt((triplet >>> (6 * (3 - j))) & 0x3f));
                    }
                }

                // Add padding
                var paddingChar = map.charAt(64);
                if (paddingChar) {
                    while (base64Chars.length % 4) {
                        base64Chars.push(paddingChar);
                    }
                }

                return base64Chars.join('');
            },

            /**
             * Converts a Base64 string to a word array.
             *
             * @param {string} base64Str The Base64 string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Base64.parse(base64String);
             */
            parse: function (base64Str) {
                // Shortcuts
                var base64StrLength = base64Str.length;
                var map = this._map;
                var reverseMap = this._reverseMap;

                if (!reverseMap) {
                    reverseMap = this._reverseMap = [];
                    for (var j = 0; j < map.length; j++) {
                        reverseMap[map.charCodeAt(j)] = j;
                    }
                }

                // Ignore padding
                var paddingChar = map.charAt(64);
                if (paddingChar) {
                    var paddingIndex = base64Str.indexOf(paddingChar);
                    if (paddingIndex !== -1) {
                        base64StrLength = paddingIndex;
                    }
                }

                // Convert
                return parseLoop(base64Str, base64StrLength, reverseMap);

            },

            _map: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/='
        };

        function parseLoop(base64Str, base64StrLength, reverseMap) {
            var words = [];
            var nBytes = 0;
            for (var i = 0; i < base64StrLength; i++) {
                if (i % 4) {
                    var bits1 = reverseMap[base64Str.charCodeAt(i - 1)] << ((i % 4) * 2);
                    var bits2 = reverseMap[base64Str.charCodeAt(i)] >>> (6 - (i % 4) * 2);
                    words[nBytes >>> 2] |= (bits1 | bits2) << (24 - (nBytes % 4) * 8);
                    nBytes++;
                }
            }
            return WordArray.create(words, nBytes);
        }
    }());


    (function (Math) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_algo = C.algo;

        // Constants table
        var T = [];

        // Compute constants
        (function () {
            for (var i = 0; i < 64; i++) {
                T[i] = (Math.abs(Math.sin(i + 1)) * 0x100000000) | 0;
            }
        }());

        /**
         * MD5 hash algorithm.
         */
        var MD5 = C_algo.MD5 = Hasher.extend({
            _doReset: function () {
                this._hash = new WordArray.init([
                    0x67452301, 0xefcdab89,
                    0x98badcfe, 0x10325476
                ]);
            },

            _doProcessBlock: function (M, offset) {
                // Swap endian
                for (var i = 0; i < 16; i++) {
                    // Shortcuts
                    var offset_i = offset + i;
                    var M_offset_i = M[offset_i];

                    M[offset_i] = (
                        (((M_offset_i << 8)  | (M_offset_i >>> 24)) & 0x00ff00ff) |
                        (((M_offset_i << 24) | (M_offset_i >>> 8))  & 0xff00ff00)
                    );
                }

                // Shortcuts
                var H = this._hash.words;

                var M_offset_0  = M[offset + 0];
                var M_offset_1  = M[offset + 1];
                var M_offset_2  = M[offset + 2];
                var M_offset_3  = M[offset + 3];
                var M_offset_4  = M[offset + 4];
                var M_offset_5  = M[offset + 5];
                var M_offset_6  = M[offset + 6];
                var M_offset_7  = M[offset + 7];
                var M_offset_8  = M[offset + 8];
                var M_offset_9  = M[offset + 9];
                var M_offset_10 = M[offset + 10];
                var M_offset_11 = M[offset + 11];
                var M_offset_12 = M[offset + 12];
                var M_offset_13 = M[offset + 13];
                var M_offset_14 = M[offset + 14];
                var M_offset_15 = M[offset + 15];

                // Working varialbes
                var a = H[0];
                var b = H[1];
                var c = H[2];
                var d = H[3];

                // Computation
                a = FF(a, b, c, d, M_offset_0,  7,  T[0]);
                d = FF(d, a, b, c, M_offset_1,  12, T[1]);
                c = FF(c, d, a, b, M_offset_2,  17, T[2]);
                b = FF(b, c, d, a, M_offset_3,  22, T[3]);
                a = FF(a, b, c, d, M_offset_4,  7,  T[4]);
                d = FF(d, a, b, c, M_offset_5,  12, T[5]);
                c = FF(c, d, a, b, M_offset_6,  17, T[6]);
                b = FF(b, c, d, a, M_offset_7,  22, T[7]);
                a = FF(a, b, c, d, M_offset_8,  7,  T[8]);
                d = FF(d, a, b, c, M_offset_9,  12, T[9]);
                c = FF(c, d, a, b, M_offset_10, 17, T[10]);
                b = FF(b, c, d, a, M_offset_11, 22, T[11]);
                a = FF(a, b, c, d, M_offset_12, 7,  T[12]);
                d = FF(d, a, b, c, M_offset_13, 12, T[13]);
                c = FF(c, d, a, b, M_offset_14, 17, T[14]);
                b = FF(b, c, d, a, M_offset_15, 22, T[15]);

                a = GG(a, b, c, d, M_offset_1,  5,  T[16]);
                d = GG(d, a, b, c, M_offset_6,  9,  T[17]);
                c = GG(c, d, a, b, M_offset_11, 14, T[18]);
                b = GG(b, c, d, a, M_offset_0,  20, T[19]);
                a = GG(a, b, c, d, M_offset_5,  5,  T[20]);
                d = GG(d, a, b, c, M_offset_10, 9,  T[21]);
                c = GG(c, d, a, b, M_offset_15, 14, T[22]);
                b = GG(b, c, d, a, M_offset_4,  20, T[23]);
                a = GG(a, b, c, d, M_offset_9,  5,  T[24]);
                d = GG(d, a, b, c, M_offset_14, 9,  T[25]);
                c = GG(c, d, a, b, M_offset_3,  14, T[26]);
                b = GG(b, c, d, a, M_offset_8,  20, T[27]);
                a = GG(a, b, c, d, M_offset_13, 5,  T[28]);
                d = GG(d, a, b, c, M_offset_2,  9,  T[29]);
                c = GG(c, d, a, b, M_offset_7,  14, T[30]);
                b = GG(b, c, d, a, M_offset_12, 20, T[31]);

                a = HH(a, b, c, d, M_offset_5,  4,  T[32]);
                d = HH(d, a, b, c, M_offset_8,  11, T[33]);
                c = HH(c, d, a, b, M_offset_11, 16, T[34]);
                b = HH(b, c, d, a, M_offset_14, 23, T[35]);
                a = HH(a, b, c, d, M_offset_1,  4,  T[36]);
                d = HH(d, a, b, c, M_offset_4,  11, T[37]);
                c = HH(c, d, a, b, M_offset_7,  16, T[38]);
                b = HH(b, c, d, a, M_offset_10, 23, T[39]);
                a = HH(a, b, c, d, M_offset_13, 4,  T[40]);
                d = HH(d, a, b, c, M_offset_0,  11, T[41]);
                c = HH(c, d, a, b, M_offset_3,  16, T[42]);
                b = HH(b, c, d, a, M_offset_6,  23, T[43]);
                a = HH(a, b, c, d, M_offset_9,  4,  T[44]);
                d = HH(d, a, b, c, M_offset_12, 11, T[45]);
                c = HH(c, d, a, b, M_offset_15, 16, T[46]);
                b = HH(b, c, d, a, M_offset_2,  23, T[47]);

                a = II(a, b, c, d, M_offset_0,  6,  T[48]);
                d = II(d, a, b, c, M_offset_7,  10, T[49]);
                c = II(c, d, a, b, M_offset_14, 15, T[50]);
                b = II(b, c, d, a, M_offset_5,  21, T[51]);
                a = II(a, b, c, d, M_offset_12, 6,  T[52]);
                d = II(d, a, b, c, M_offset_3,  10, T[53]);
                c = II(c, d, a, b, M_offset_10, 15, T[54]);
                b = II(b, c, d, a, M_offset_1,  21, T[55]);
                a = II(a, b, c, d, M_offset_8,  6,  T[56]);
                d = II(d, a, b, c, M_offset_15, 10, T[57]);
                c = II(c, d, a, b, M_offset_6,  15, T[58]);
                b = II(b, c, d, a, M_offset_13, 21, T[59]);
                a = II(a, b, c, d, M_offset_4,  6,  T[60]);
                d = II(d, a, b, c, M_offset_11, 10, T[61]);
                c = II(c, d, a, b, M_offset_2,  15, T[62]);
                b = II(b, c, d, a, M_offset_9,  21, T[63]);

                // Intermediate hash value
                H[0] = (H[0] + a) | 0;
                H[1] = (H[1] + b) | 0;
                H[2] = (H[2] + c) | 0;
                H[3] = (H[3] + d) | 0;
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);

                var nBitsTotalH = Math.floor(nBitsTotal / 0x100000000);
                var nBitsTotalL = nBitsTotal;
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 15] = (
                    (((nBitsTotalH << 8)  | (nBitsTotalH >>> 24)) & 0x00ff00ff) |
                    (((nBitsTotalH << 24) | (nBitsTotalH >>> 8))  & 0xff00ff00)
                );
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 14] = (
                    (((nBitsTotalL << 8)  | (nBitsTotalL >>> 24)) & 0x00ff00ff) |
                    (((nBitsTotalL << 24) | (nBitsTotalL >>> 8))  & 0xff00ff00)
                );

                data.sigBytes = (dataWords.length + 1) * 4;

                // Hash final blocks
                this._process();

                // Shortcuts
                var hash = this._hash;
                var H = hash.words;

                // Swap endian
                for (var i = 0; i < 4; i++) {
                    // Shortcut
                    var H_i = H[i];

                    H[i] = (((H_i << 8)  | (H_i >>> 24)) & 0x00ff00ff) |
                        (((H_i << 24) | (H_i >>> 8))  & 0xff00ff00);
                }

                // Return final computed hash
                return hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            }
        });

        function FF(a, b, c, d, x, s, t) {
            var n = a + ((b & c) | (~b & d)) + x + t;
            return ((n << s) | (n >>> (32 - s))) + b;
        }

        function GG(a, b, c, d, x, s, t) {
            var n = a + ((b & d) | (c & ~d)) + x + t;
            return ((n << s) | (n >>> (32 - s))) + b;
        }

        function HH(a, b, c, d, x, s, t) {
            var n = a + (b ^ c ^ d) + x + t;
            return ((n << s) | (n >>> (32 - s))) + b;
        }

        function II(a, b, c, d, x, s, t) {
            var n = a + (c ^ (b | ~d)) + x + t;
            return ((n << s) | (n >>> (32 - s))) + b;
        }

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.MD5('message');
         *     var hash = CryptoJS.MD5(wordArray);
         */
        C.MD5 = Hasher._createHelper(MD5);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacMD5(message, key);
         */
        C.HmacMD5 = Hasher._createHmacHelper(MD5);
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_algo = C.algo;

        // Reusable object
        var W = [];

        /**
         * SHA-1 hash algorithm.
         */
        var SHA1 = C_algo.SHA1 = Hasher.extend({
            _doReset: function () {
                this._hash = new WordArray.init([
                    0x67452301, 0xefcdab89,
                    0x98badcfe, 0x10325476,
                    0xc3d2e1f0
                ]);
            },

            _doProcessBlock: function (M, offset) {
                // Shortcut
                var H = this._hash.words;

                // Working variables
                var a = H[0];
                var b = H[1];
                var c = H[2];
                var d = H[3];
                var e = H[4];

                // Computation
                for (var i = 0; i < 80; i++) {
                    if (i < 16) {
                        W[i] = M[offset + i] | 0;
                    } else {
                        var n = W[i - 3] ^ W[i - 8] ^ W[i - 14] ^ W[i - 16];
                        W[i] = (n << 1) | (n >>> 31);
                    }

                    var t = ((a << 5) | (a >>> 27)) + e + W[i];
                    if (i < 20) {
                        t += ((b & c) | (~b & d)) + 0x5a827999;
                    } else if (i < 40) {
                        t += (b ^ c ^ d) + 0x6ed9eba1;
                    } else if (i < 60) {
                        t += ((b & c) | (b & d) | (c & d)) - 0x70e44324;
                    } else /* if (i < 80) */ {
                        t += (b ^ c ^ d) - 0x359d3e2a;
                    }

                    e = d;
                    d = c;
                    c = (b << 30) | (b >>> 2);
                    b = a;
                    a = t;
                }

                // Intermediate hash value
                H[0] = (H[0] + a) | 0;
                H[1] = (H[1] + b) | 0;
                H[2] = (H[2] + c) | 0;
                H[3] = (H[3] + d) | 0;
                H[4] = (H[4] + e) | 0;
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 14] = Math.floor(nBitsTotal / 0x100000000);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 15] = nBitsTotal;
                data.sigBytes = dataWords.length * 4;

                // Hash final blocks
                this._process();

                // Return final computed hash
                return this._hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA1('message');
         *     var hash = CryptoJS.SHA1(wordArray);
         */
        C.SHA1 = Hasher._createHelper(SHA1);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA1(message, key);
         */
        C.HmacSHA1 = Hasher._createHmacHelper(SHA1);
    }());


    (function (Math) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_algo = C.algo;

        // Initialization and round constants tables
        var H = [];
        var K = [];

        // Compute constants
        (function () {
            function isPrime(n) {
                var sqrtN = Math.sqrt(n);
                for (var factor = 2; factor <= sqrtN; factor++) {
                    if (!(n % factor)) {
                        return false;
                    }
                }

                return true;
            }

            function getFractionalBits(n) {
                return ((n - (n | 0)) * 0x100000000) | 0;
            }

            var n = 2;
            var nPrime = 0;
            while (nPrime < 64) {
                if (isPrime(n)) {
                    if (nPrime < 8) {
                        H[nPrime] = getFractionalBits(Math.pow(n, 1 / 2));
                    }
                    K[nPrime] = getFractionalBits(Math.pow(n, 1 / 3));

                    nPrime++;
                }

                n++;
            }
        }());

        // Reusable object
        var W = [];

        /**
         * SHA-256 hash algorithm.
         */
        var SHA256 = C_algo.SHA256 = Hasher.extend({
            _doReset: function () {
                this._hash = new WordArray.init(H.slice(0));
            },

            _doProcessBlock: function (M, offset) {
                // Shortcut
                var H = this._hash.words;

                // Working variables
                var a = H[0];
                var b = H[1];
                var c = H[2];
                var d = H[3];
                var e = H[4];
                var f = H[5];
                var g = H[6];
                var h = H[7];

                // Computation
                for (var i = 0; i < 64; i++) {
                    if (i < 16) {
                        W[i] = M[offset + i] | 0;
                    } else {
                        var gamma0x = W[i - 15];
                        var gamma0  = ((gamma0x << 25) | (gamma0x >>> 7))  ^
                            ((gamma0x << 14) | (gamma0x >>> 18)) ^
                            (gamma0x >>> 3);

                        var gamma1x = W[i - 2];
                        var gamma1  = ((gamma1x << 15) | (gamma1x >>> 17)) ^
                            ((gamma1x << 13) | (gamma1x >>> 19)) ^
                            (gamma1x >>> 10);

                        W[i] = gamma0 + W[i - 7] + gamma1 + W[i - 16];
                    }

                    var ch  = (e & f) ^ (~e & g);
                    var maj = (a & b) ^ (a & c) ^ (b & c);

                    var sigma0 = ((a << 30) | (a >>> 2)) ^ ((a << 19) | (a >>> 13)) ^ ((a << 10) | (a >>> 22));
                    var sigma1 = ((e << 26) | (e >>> 6)) ^ ((e << 21) | (e >>> 11)) ^ ((e << 7)  | (e >>> 25));

                    var t1 = h + sigma1 + ch + K[i] + W[i];
                    var t2 = sigma0 + maj;

                    h = g;
                    g = f;
                    f = e;
                    e = (d + t1) | 0;
                    d = c;
                    c = b;
                    b = a;
                    a = (t1 + t2) | 0;
                }

                // Intermediate hash value
                H[0] = (H[0] + a) | 0;
                H[1] = (H[1] + b) | 0;
                H[2] = (H[2] + c) | 0;
                H[3] = (H[3] + d) | 0;
                H[4] = (H[4] + e) | 0;
                H[5] = (H[5] + f) | 0;
                H[6] = (H[6] + g) | 0;
                H[7] = (H[7] + h) | 0;
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 14] = Math.floor(nBitsTotal / 0x100000000);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 15] = nBitsTotal;
                data.sigBytes = dataWords.length * 4;

                // Hash final blocks
                this._process();

                // Return final computed hash
                return this._hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA256('message');
         *     var hash = CryptoJS.SHA256(wordArray);
         */
        C.SHA256 = Hasher._createHelper(SHA256);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA256(message, key);
         */
        C.HmacSHA256 = Hasher._createHmacHelper(SHA256);
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var C_enc = C.enc;

        /**
         * UTF-16 BE encoding strategy.
         */
        var Utf16BE = C_enc.Utf16 = C_enc.Utf16BE = {
            /**
             * Converts a word array to a UTF-16 BE string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The UTF-16 BE string.
             *
             * @static
             *
             * @example
             *
             *     var utf16String = CryptoJS.enc.Utf16.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;

                // Convert
                var utf16Chars = [];
                for (var i = 0; i < sigBytes; i += 2) {
                    var codePoint = (words[i >>> 2] >>> (16 - (i % 4) * 8)) & 0xffff;
                    utf16Chars.push(String.fromCharCode(codePoint));
                }

                return utf16Chars.join('');
            },

            /**
             * Converts a UTF-16 BE string to a word array.
             *
             * @param {string} utf16Str The UTF-16 BE string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Utf16.parse(utf16String);
             */
            parse: function (utf16Str) {
                // Shortcut
                var utf16StrLength = utf16Str.length;

                // Convert
                var words = [];
                for (var i = 0; i < utf16StrLength; i++) {
                    words[i >>> 1] |= utf16Str.charCodeAt(i) << (16 - (i % 2) * 16);
                }

                return WordArray.create(words, utf16StrLength * 2);
            }
        };

        /**
         * UTF-16 LE encoding strategy.
         */
        C_enc.Utf16LE = {
            /**
             * Converts a word array to a UTF-16 LE string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The UTF-16 LE string.
             *
             * @static
             *
             * @example
             *
             *     var utf16Str = CryptoJS.enc.Utf16LE.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;

                // Convert
                var utf16Chars = [];
                for (var i = 0; i < sigBytes; i += 2) {
                    var codePoint = swapEndian((words[i >>> 2] >>> (16 - (i % 4) * 8)) & 0xffff);
                    utf16Chars.push(String.fromCharCode(codePoint));
                }

                return utf16Chars.join('');
            },

            /**
             * Converts a UTF-16 LE string to a word array.
             *
             * @param {string} utf16Str The UTF-16 LE string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Utf16LE.parse(utf16Str);
             */
            parse: function (utf16Str) {
                // Shortcut
                var utf16StrLength = utf16Str.length;

                // Convert
                var words = [];
                for (var i = 0; i < utf16StrLength; i++) {
                    words[i >>> 1] |= swapEndian(utf16Str.charCodeAt(i) << (16 - (i % 2) * 16));
                }

                return WordArray.create(words, utf16StrLength * 2);
            }
        };

        function swapEndian(word) {
            return ((word << 8) & 0xff00ff00) | ((word >>> 8) & 0x00ff00ff);
        }
    }());


    (function () {
        // Check if typed arrays are supported
        if (typeof ArrayBuffer != 'function') {
            return;
        }

        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;

        // Reference original init
        var superInit = WordArray.init;

        // Augment WordArray.init to handle typed arrays
        var subInit = WordArray.init = function (typedArray) {
            // Convert buffers to uint8
            if (typedArray instanceof ArrayBuffer) {
                typedArray = new Uint8Array(typedArray);
            }

            // Convert other array views to uint8
            if (
                typedArray instanceof Int8Array ||
                (typeof Uint8ClampedArray !== "undefined" && typedArray instanceof Uint8ClampedArray) ||
                typedArray instanceof Int16Array ||
                typedArray instanceof Uint16Array ||
                typedArray instanceof Int32Array ||
                typedArray instanceof Uint32Array ||
                typedArray instanceof Float32Array ||
                typedArray instanceof Float64Array
            ) {
                typedArray = new Uint8Array(typedArray.buffer, typedArray.byteOffset, typedArray.byteLength);
            }

            // Handle Uint8Array
            if (typedArray instanceof Uint8Array) {
                // Shortcut
                var typedArrayByteLength = typedArray.byteLength;

                // Extract bytes
                var words = [];
                for (var i = 0; i < typedArrayByteLength; i++) {
                    words[i >>> 2] |= typedArray[i] << (24 - (i % 4) * 8);
                }

                // Initialize this word array
                superInit.call(this, words, typedArrayByteLength);
            } else {
                // Else call normal init
                superInit.apply(this, arguments);
            }
        };

        subInit.prototype = WordArray;
    }());


    /** @preserve
     (c) 2012 by Cédric Mesnil. All rights reserved.

     Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

     - Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
     - Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

     THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
     */

    (function (Math) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_algo = C.algo;

        // Constants table
        var _zl = WordArray.create([
            0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15,
            7,  4, 13,  1, 10,  6, 15,  3, 12,  0,  9,  5,  2, 14, 11,  8,
            3, 10, 14,  4,  9, 15,  8,  1,  2,  7,  0,  6, 13, 11,  5, 12,
            1,  9, 11, 10,  0,  8, 12,  4, 13,  3,  7, 15, 14,  5,  6,  2,
            4,  0,  5,  9,  7, 12,  2, 10, 14,  1,  3,  8, 11,  6, 15, 13]);
        var _zr = WordArray.create([
            5, 14,  7,  0,  9,  2, 11,  4, 13,  6, 15,  8,  1, 10,  3, 12,
            6, 11,  3,  7,  0, 13,  5, 10, 14, 15,  8, 12,  4,  9,  1,  2,
            15,  5,  1,  3,  7, 14,  6,  9, 11,  8, 12,  2, 10,  0,  4, 13,
            8,  6,  4,  1,  3, 11, 15,  0,  5, 12,  2, 13,  9,  7, 10, 14,
            12, 15, 10,  4,  1,  5,  8,  7,  6,  2, 13, 14,  0,  3,  9, 11]);
        var _sl = WordArray.create([
            11, 14, 15, 12,  5,  8,  7,  9, 11, 13, 14, 15,  6,  7,  9,  8,
            7, 6,   8, 13, 11,  9,  7, 15,  7, 12, 15,  9, 11,  7, 13, 12,
            11, 13,  6,  7, 14,  9, 13, 15, 14,  8, 13,  6,  5, 12,  7,  5,
            11, 12, 14, 15, 14, 15,  9,  8,  9, 14,  5,  6,  8,  6,  5, 12,
            9, 15,  5, 11,  6,  8, 13, 12,  5, 12, 13, 14, 11,  8,  5,  6 ]);
        var _sr = WordArray.create([
            8,  9,  9, 11, 13, 15, 15,  5,  7,  7,  8, 11, 14, 14, 12,  6,
            9, 13, 15,  7, 12,  8,  9, 11,  7,  7, 12,  7,  6, 15, 13, 11,
            9,  7, 15, 11,  8,  6,  6, 14, 12, 13,  5, 14, 13, 13,  7,  5,
            15,  5,  8, 11, 14, 14,  6, 14,  6,  9, 12,  9, 12,  5, 15,  8,
            8,  5, 12,  9, 12,  5, 14,  6,  8, 13,  6,  5, 15, 13, 11, 11 ]);

        var _hl =  WordArray.create([ 0x00000000, 0x5A827999, 0x6ED9EBA1, 0x8F1BBCDC, 0xA953FD4E]);
        var _hr =  WordArray.create([ 0x50A28BE6, 0x5C4DD124, 0x6D703EF3, 0x7A6D76E9, 0x00000000]);

        /**
         * RIPEMD160 hash algorithm.
         */
        var RIPEMD160 = C_algo.RIPEMD160 = Hasher.extend({
            _doReset: function () {
                this._hash  = WordArray.create([0x67452301, 0xEFCDAB89, 0x98BADCFE, 0x10325476, 0xC3D2E1F0]);
            },

            _doProcessBlock: function (M, offset) {

                // Swap endian
                for (var i = 0; i < 16; i++) {
                    // Shortcuts
                    var offset_i = offset + i;
                    var M_offset_i = M[offset_i];

                    // Swap
                    M[offset_i] = (
                        (((M_offset_i << 8)  | (M_offset_i >>> 24)) & 0x00ff00ff) |
                        (((M_offset_i << 24) | (M_offset_i >>> 8))  & 0xff00ff00)
                    );
                }
                // Shortcut
                var H  = this._hash.words;
                var hl = _hl.words;
                var hr = _hr.words;
                var zl = _zl.words;
                var zr = _zr.words;
                var sl = _sl.words;
                var sr = _sr.words;

                // Working variables
                var al, bl, cl, dl, el;
                var ar, br, cr, dr, er;

                ar = al = H[0];
                br = bl = H[1];
                cr = cl = H[2];
                dr = dl = H[3];
                er = el = H[4];
                // Computation
                var t;
                for (var i = 0; i < 80; i += 1) {
                    t = (al +  M[offset+zl[i]])|0;
                    if (i<16){
                        t +=  f1(bl,cl,dl) + hl[0];
                    } else if (i<32) {
                        t +=  f2(bl,cl,dl) + hl[1];
                    } else if (i<48) {
                        t +=  f3(bl,cl,dl) + hl[2];
                    } else if (i<64) {
                        t +=  f4(bl,cl,dl) + hl[3];
                    } else {// if (i<80) {
                        t +=  f5(bl,cl,dl) + hl[4];
                    }
                    t = t|0;
                    t =  rotl(t,sl[i]);
                    t = (t+el)|0;
                    al = el;
                    el = dl;
                    dl = rotl(cl, 10);
                    cl = bl;
                    bl = t;

                    t = (ar + M[offset+zr[i]])|0;
                    if (i<16){
                        t +=  f5(br,cr,dr) + hr[0];
                    } else if (i<32) {
                        t +=  f4(br,cr,dr) + hr[1];
                    } else if (i<48) {
                        t +=  f3(br,cr,dr) + hr[2];
                    } else if (i<64) {
                        t +=  f2(br,cr,dr) + hr[3];
                    } else {// if (i<80) {
                        t +=  f1(br,cr,dr) + hr[4];
                    }
                    t = t|0;
                    t =  rotl(t,sr[i]) ;
                    t = (t+er)|0;
                    ar = er;
                    er = dr;
                    dr = rotl(cr, 10);
                    cr = br;
                    br = t;
                }
                // Intermediate hash value
                t    = (H[1] + cl + dr)|0;
                H[1] = (H[2] + dl + er)|0;
                H[2] = (H[3] + el + ar)|0;
                H[3] = (H[4] + al + br)|0;
                H[4] = (H[0] + bl + cr)|0;
                H[0] =  t;
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 14] = (
                    (((nBitsTotal << 8)  | (nBitsTotal >>> 24)) & 0x00ff00ff) |
                    (((nBitsTotal << 24) | (nBitsTotal >>> 8))  & 0xff00ff00)
                );
                data.sigBytes = (dataWords.length + 1) * 4;

                // Hash final blocks
                this._process();

                // Shortcuts
                var hash = this._hash;
                var H = hash.words;

                // Swap endian
                for (var i = 0; i < 5; i++) {
                    // Shortcut
                    var H_i = H[i];

                    // Swap
                    H[i] = (((H_i << 8)  | (H_i >>> 24)) & 0x00ff00ff) |
                        (((H_i << 24) | (H_i >>> 8))  & 0xff00ff00);
                }

                // Return final computed hash
                return hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            }
        });


        function f1(x, y, z) {
            return ((x) ^ (y) ^ (z));

        }

        function f2(x, y, z) {
            return (((x)&(y)) | ((~x)&(z)));
        }

        function f3(x, y, z) {
            return (((x) | (~(y))) ^ (z));
        }

        function f4(x, y, z) {
            return (((x) & (z)) | ((y)&(~(z))));
        }

        function f5(x, y, z) {
            return ((x) ^ ((y) |(~(z))));

        }

        function rotl(x,n) {
            return (x<<n) | (x>>>(32-n));
        }


        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.RIPEMD160('message');
         *     var hash = CryptoJS.RIPEMD160(wordArray);
         */
        C.RIPEMD160 = Hasher._createHelper(RIPEMD160);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacRIPEMD160(message, key);
         */
        C.HmacRIPEMD160 = Hasher._createHmacHelper(RIPEMD160);
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var C_enc = C.enc;
        var Utf8 = C_enc.Utf8;
        var C_algo = C.algo;

        /**
         * HMAC algorithm.
         */
        var HMAC = C_algo.HMAC = Base.extend({
            /**
             * Initializes a newly created HMAC.
             *
             * @param {Hasher} hasher The hash algorithm to use.
             * @param {WordArray|string} key The secret key.
             *
             * @example
             *
             *     var hmacHasher = CryptoJS.algo.HMAC.create(CryptoJS.algo.SHA256, key);
             */
            init: function (hasher, key) {
                // Init hasher
                hasher = this._hasher = new hasher.init();

                // Convert string to WordArray, else assume WordArray already
                if (typeof key == 'string') {
                    key = Utf8.parse(key);
                }

                // Shortcuts
                var hasherBlockSize = hasher.blockSize;
                var hasherBlockSizeBytes = hasherBlockSize * 4;

                // Allow arbitrary length keys
                if (key.sigBytes > hasherBlockSizeBytes) {
                    key = hasher.finalize(key);
                }

                // Clamp excess bits
                key.clamp();

                // Clone key for inner and outer pads
                var oKey = this._oKey = key.clone();
                var iKey = this._iKey = key.clone();

                // Shortcuts
                var oKeyWords = oKey.words;
                var iKeyWords = iKey.words;

                // XOR keys with pad constants
                for (var i = 0; i < hasherBlockSize; i++) {
                    oKeyWords[i] ^= 0x5c5c5c5c;
                    iKeyWords[i] ^= 0x36363636;
                }
                oKey.sigBytes = iKey.sigBytes = hasherBlockSizeBytes;

                // Set initial values
                this.reset();
            },

            /**
             * Resets this HMAC to its initial state.
             *
             * @example
             *
             *     hmacHasher.reset();
             */
            reset: function () {
                // Shortcut
                var hasher = this._hasher;

                // Reset
                hasher.reset();
                hasher.update(this._iKey);
            },

            /**
             * Updates this HMAC with a message.
             *
             * @param {WordArray|string} messageUpdate The message to append.
             *
             * @return {HMAC} This HMAC instance.
             *
             * @example
             *
             *     hmacHasher.update('message');
             *     hmacHasher.update(wordArray);
             */
            update: function (messageUpdate) {
                this._hasher.update(messageUpdate);

                // Chainable
                return this;
            },

            /**
             * Finalizes the HMAC computation.
             * Note that the finalize operation is effectively a destructive, read-once operation.
             *
             * @param {WordArray|string} messageUpdate (Optional) A final message update.
             *
             * @return {WordArray} The HMAC.
             *
             * @example
             *
             *     var hmac = hmacHasher.finalize();
             *     var hmac = hmacHasher.finalize('message');
             *     var hmac = hmacHasher.finalize(wordArray);
             */
            finalize: function (messageUpdate) {
                // Shortcut
                var hasher = this._hasher;

                // Compute HMAC
                var innerHash = hasher.finalize(messageUpdate);
                hasher.reset();
                var hmac = hasher.finalize(this._oKey.clone().concat(innerHash));

                return hmac;
            }
        });
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var WordArray = C_lib.WordArray;
        var C_algo = C.algo;
        var SHA1 = C_algo.SHA1;
        var HMAC = C_algo.HMAC;

        /**
         * Password-Based Key Derivation Function 2 algorithm.
         */
        var PBKDF2 = C_algo.PBKDF2 = Base.extend({
            /**
             * Configuration options.
             *
             * @property {number} keySize The key size in words to generate. Default: 4 (128 bits)
             * @property {Hasher} hasher The hasher to use. Default: SHA1
             * @property {number} iterations The number of iterations to perform. Default: 1
             */
            cfg: Base.extend({
                keySize: 128/32,
                hasher: SHA1,
                iterations: 1
            }),

            /**
             * Initializes a newly created key derivation function.
             *
             * @param {Object} cfg (Optional) The configuration options to use for the derivation.
             *
             * @example
             *
             *     var kdf = CryptoJS.algo.PBKDF2.create();
             *     var kdf = CryptoJS.algo.PBKDF2.create({ keySize: 8 });
             *     var kdf = CryptoJS.algo.PBKDF2.create({ keySize: 8, iterations: 1000 });
             */
            init: function (cfg) {
                this.cfg = this.cfg.extend(cfg);
            },

            /**
             * Computes the Password-Based Key Derivation Function 2.
             *
             * @param {WordArray|string} password The password.
             * @param {WordArray|string} salt A salt.
             *
             * @return {WordArray} The derived key.
             *
             * @example
             *
             *     var key = kdf.compute(password, salt);
             */
            compute: function (password, salt) {
                // Shortcut
                var cfg = this.cfg;

                // Init HMAC
                var hmac = HMAC.create(cfg.hasher, password);

                // Initial values
                var derivedKey = WordArray.create();
                var blockIndex = WordArray.create([0x00000001]);

                // Shortcuts
                var derivedKeyWords = derivedKey.words;
                var blockIndexWords = blockIndex.words;
                var keySize = cfg.keySize;
                var iterations = cfg.iterations;

                // Generate key
                while (derivedKeyWords.length < keySize) {
                    var block = hmac.update(salt).finalize(blockIndex);
                    hmac.reset();

                    // Shortcuts
                    var blockWords = block.words;
                    var blockWordsLength = blockWords.length;

                    // Iterations
                    var intermediate = block;
                    for (var i = 1; i < iterations; i++) {
                        intermediate = hmac.finalize(intermediate);
                        hmac.reset();

                        // Shortcut
                        var intermediateWords = intermediate.words;

                        // XOR intermediate with block
                        for (var j = 0; j < blockWordsLength; j++) {
                            blockWords[j] ^= intermediateWords[j];
                        }
                    }

                    derivedKey.concat(block);
                    blockIndexWords[0]++;
                }
                derivedKey.sigBytes = keySize * 4;

                return derivedKey;
            }
        });

        /**
         * Computes the Password-Based Key Derivation Function 2.
         *
         * @param {WordArray|string} password The password.
         * @param {WordArray|string} salt A salt.
         * @param {Object} cfg (Optional) The configuration options to use for this computation.
         *
         * @return {WordArray} The derived key.
         *
         * @static
         *
         * @example
         *
         *     var key = CryptoJS.PBKDF2(password, salt);
         *     var key = CryptoJS.PBKDF2(password, salt, { keySize: 8 });
         *     var key = CryptoJS.PBKDF2(password, salt, { keySize: 8, iterations: 1000 });
         */
        C.PBKDF2 = function (password, salt, cfg) {
            return PBKDF2.create(cfg).compute(password, salt);
        };
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var WordArray = C_lib.WordArray;
        var C_algo = C.algo;
        var MD5 = C_algo.MD5;

        /**
         * This key derivation function is meant to conform with EVP_BytesToKey.
         * www.openssl.org/docs/crypto/EVP_BytesToKey.html
         */
        var EvpKDF = C_algo.EvpKDF = Base.extend({
            /**
             * Configuration options.
             *
             * @property {number} keySize The key size in words to generate. Default: 4 (128 bits)
             * @property {Hasher} hasher The hash algorithm to use. Default: MD5
             * @property {number} iterations The number of iterations to perform. Default: 1
             */
            cfg: Base.extend({
                keySize: 128/32,
                hasher: MD5,
                iterations: 1
            }),

            /**
             * Initializes a newly created key derivation function.
             *
             * @param {Object} cfg (Optional) The configuration options to use for the derivation.
             *
             * @example
             *
             *     var kdf = CryptoJS.algo.EvpKDF.create();
             *     var kdf = CryptoJS.algo.EvpKDF.create({ keySize: 8 });
             *     var kdf = CryptoJS.algo.EvpKDF.create({ keySize: 8, iterations: 1000 });
             */
            init: function (cfg) {
                this.cfg = this.cfg.extend(cfg);
            },

            /**
             * Derives a key from a password.
             *
             * @param {WordArray|string} password The password.
             * @param {WordArray|string} salt A salt.
             *
             * @return {WordArray} The derived key.
             *
             * @example
             *
             *     var key = kdf.compute(password, salt);
             */
            compute: function (password, salt) {
                // Shortcut
                var cfg = this.cfg;

                // Init hasher
                var hasher = cfg.hasher.create();

                // Initial values
                var derivedKey = WordArray.create();

                // Shortcuts
                var derivedKeyWords = derivedKey.words;
                var keySize = cfg.keySize;
                var iterations = cfg.iterations;

                // Generate key
                while (derivedKeyWords.length < keySize) {
                    if (block) {
                        hasher.update(block);
                    }
                    var block = hasher.update(password).finalize(salt);
                    hasher.reset();

                    // Iterations
                    for (var i = 1; i < iterations; i++) {
                        block = hasher.finalize(block);
                        hasher.reset();
                    }

                    derivedKey.concat(block);
                }
                derivedKey.sigBytes = keySize * 4;

                return derivedKey;
            }
        });

        /**
         * Derives a key from a password.
         *
         * @param {WordArray|string} password The password.
         * @param {WordArray|string} salt A salt.
         * @param {Object} cfg (Optional) The configuration options to use for this computation.
         *
         * @return {WordArray} The derived key.
         *
         * @static
         *
         * @example
         *
         *     var key = CryptoJS.EvpKDF(password, salt);
         *     var key = CryptoJS.EvpKDF(password, salt, { keySize: 8 });
         *     var key = CryptoJS.EvpKDF(password, salt, { keySize: 8, iterations: 1000 });
         */
        C.EvpKDF = function (password, salt, cfg) {
            return EvpKDF.create(cfg).compute(password, salt);
        };
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var C_algo = C.algo;
        var SHA256 = C_algo.SHA256;

        /**
         * SHA-224 hash algorithm.
         */
        var SHA224 = C_algo.SHA224 = SHA256.extend({
            _doReset: function () {
                this._hash = new WordArray.init([
                    0xc1059ed8, 0x367cd507, 0x3070dd17, 0xf70e5939,
                    0xffc00b31, 0x68581511, 0x64f98fa7, 0xbefa4fa4
                ]);
            },

            _doFinalize: function () {
                var hash = SHA256._doFinalize.call(this);

                hash.sigBytes -= 4;

                return hash;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA224('message');
         *     var hash = CryptoJS.SHA224(wordArray);
         */
        C.SHA224 = SHA256._createHelper(SHA224);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA224(message, key);
         */
        C.HmacSHA224 = SHA256._createHmacHelper(SHA224);
    }());


    (function (undefined) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var X32WordArray = C_lib.WordArray;

        /**
         * x64 namespace.
         */
        var C_x64 = C.x64 = {};

        /**
         * A 64-bit word.
         */
        var X64Word = C_x64.Word = Base.extend({
            /**
             * Initializes a newly created 64-bit word.
             *
             * @param {number} high The high 32 bits.
             * @param {number} low The low 32 bits.
             *
             * @example
             *
             *     var x64Word = CryptoJS.x64.Word.create(0x00010203, 0x04050607);
             */
            init: function (high, low) {
                this.high = high;
                this.low = low;
            }

            /**
             * Bitwise NOTs this word.
             *
             * @return {X64Word} A new x64-Word object after negating.
             *
             * @example
             *
             *     var negated = x64Word.not();
             */
            // not: function () {
            // var high = ~this.high;
            // var low = ~this.low;

            // return X64Word.create(high, low);
            // },

            /**
             * Bitwise ANDs this word with the passed word.
             *
             * @param {X64Word} word The x64-Word to AND with this word.
             *
             * @return {X64Word} A new x64-Word object after ANDing.
             *
             * @example
             *
             *     var anded = x64Word.and(anotherX64Word);
             */
            // and: function (word) {
            // var high = this.high & word.high;
            // var low = this.low & word.low;

            // return X64Word.create(high, low);
            // },

            /**
             * Bitwise ORs this word with the passed word.
             *
             * @param {X64Word} word The x64-Word to OR with this word.
             *
             * @return {X64Word} A new x64-Word object after ORing.
             *
             * @example
             *
             *     var ored = x64Word.or(anotherX64Word);
             */
            // or: function (word) {
            // var high = this.high | word.high;
            // var low = this.low | word.low;

            // return X64Word.create(high, low);
            // },

            /**
             * Bitwise XORs this word with the passed word.
             *
             * @param {X64Word} word The x64-Word to XOR with this word.
             *
             * @return {X64Word} A new x64-Word object after XORing.
             *
             * @example
             *
             *     var xored = x64Word.xor(anotherX64Word);
             */
            // xor: function (word) {
            // var high = this.high ^ word.high;
            // var low = this.low ^ word.low;

            // return X64Word.create(high, low);
            // },

            /**
             * Shifts this word n bits to the left.
             *
             * @param {number} n The number of bits to shift.
             *
             * @return {X64Word} A new x64-Word object after shifting.
             *
             * @example
             *
             *     var shifted = x64Word.shiftL(25);
             */
            // shiftL: function (n) {
            // if (n < 32) {
            // var high = (this.high << n) | (this.low >>> (32 - n));
            // var low = this.low << n;
            // } else {
            // var high = this.low << (n - 32);
            // var low = 0;
            // }

            // return X64Word.create(high, low);
            // },

            /**
             * Shifts this word n bits to the right.
             *
             * @param {number} n The number of bits to shift.
             *
             * @return {X64Word} A new x64-Word object after shifting.
             *
             * @example
             *
             *     var shifted = x64Word.shiftR(7);
             */
            // shiftR: function (n) {
            // if (n < 32) {
            // var low = (this.low >>> n) | (this.high << (32 - n));
            // var high = this.high >>> n;
            // } else {
            // var low = this.high >>> (n - 32);
            // var high = 0;
            // }

            // return X64Word.create(high, low);
            // },

            /**
             * Rotates this word n bits to the left.
             *
             * @param {number} n The number of bits to rotate.
             *
             * @return {X64Word} A new x64-Word object after rotating.
             *
             * @example
             *
             *     var rotated = x64Word.rotL(25);
             */
            // rotL: function (n) {
            // return this.shiftL(n).or(this.shiftR(64 - n));
            // },

            /**
             * Rotates this word n bits to the right.
             *
             * @param {number} n The number of bits to rotate.
             *
             * @return {X64Word} A new x64-Word object after rotating.
             *
             * @example
             *
             *     var rotated = x64Word.rotR(7);
             */
            // rotR: function (n) {
            // return this.shiftR(n).or(this.shiftL(64 - n));
            // },

            /**
             * Adds this word with the passed word.
             *
             * @param {X64Word} word The x64-Word to add with this word.
             *
             * @return {X64Word} A new x64-Word object after adding.
             *
             * @example
             *
             *     var added = x64Word.add(anotherX64Word);
             */
            // add: function (word) {
            // var low = (this.low + word.low) | 0;
            // var carry = (low >>> 0) < (this.low >>> 0) ? 1 : 0;
            // var high = (this.high + word.high + carry) | 0;

            // return X64Word.create(high, low);
            // }
        });

        /**
         * An array of 64-bit words.
         *
         * @property {Array} words The array of CryptoJS.x64.Word objects.
         * @property {number} sigBytes The number of significant bytes in this word array.
         */
        var X64WordArray = C_x64.WordArray = Base.extend({
            /**
             * Initializes a newly created word array.
             *
             * @param {Array} words (Optional) An array of CryptoJS.x64.Word objects.
             * @param {number} sigBytes (Optional) The number of significant bytes in the words.
             *
             * @example
             *
             *     var wordArray = CryptoJS.x64.WordArray.create();
             *
             *     var wordArray = CryptoJS.x64.WordArray.create([
             *         CryptoJS.x64.Word.create(0x00010203, 0x04050607),
             *         CryptoJS.x64.Word.create(0x18191a1b, 0x1c1d1e1f)
             *     ]);
             *
             *     var wordArray = CryptoJS.x64.WordArray.create([
             *         CryptoJS.x64.Word.create(0x00010203, 0x04050607),
             *         CryptoJS.x64.Word.create(0x18191a1b, 0x1c1d1e1f)
             *     ], 10);
             */
            init: function (words, sigBytes) {
                words = this.words = words || [];

                if (sigBytes != undefined) {
                    this.sigBytes = sigBytes;
                } else {
                    this.sigBytes = words.length * 8;
                }
            },

            /**
             * Converts this 64-bit word array to a 32-bit word array.
             *
             * @return {CryptoJS.lib.WordArray} This word array's data as a 32-bit word array.
             *
             * @example
             *
             *     var x32WordArray = x64WordArray.toX32();
             */
            toX32: function () {
                // Shortcuts
                var x64Words = this.words;
                var x64WordsLength = x64Words.length;

                // Convert
                var x32Words = [];
                for (var i = 0; i < x64WordsLength; i++) {
                    var x64Word = x64Words[i];
                    x32Words.push(x64Word.high);
                    x32Words.push(x64Word.low);
                }

                return X32WordArray.create(x32Words, this.sigBytes);
            },

            /**
             * Creates a copy of this word array.
             *
             * @return {X64WordArray} The clone.
             *
             * @example
             *
             *     var clone = x64WordArray.clone();
             */
            clone: function () {
                var clone = Base.clone.call(this);

                // Clone "words" array
                var words = clone.words = this.words.slice(0);

                // Clone each X64Word object
                var wordsLength = words.length;
                for (var i = 0; i < wordsLength; i++) {
                    words[i] = words[i].clone();
                }

                return clone;
            }
        });
    }());


    (function (Math) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_x64 = C.x64;
        var X64Word = C_x64.Word;
        var C_algo = C.algo;

        // Constants tables
        var RHO_OFFSETS = [];
        var PI_INDEXES  = [];
        var ROUND_CONSTANTS = [];

        // Compute Constants
        (function () {
            // Compute rho offset constants
            var x = 1, y = 0;
            for (var t = 0; t < 24; t++) {
                RHO_OFFSETS[x + 5 * y] = ((t + 1) * (t + 2) / 2) % 64;

                var newX = y % 5;
                var newY = (2 * x + 3 * y) % 5;
                x = newX;
                y = newY;
            }

            // Compute pi index constants
            for (var x = 0; x < 5; x++) {
                for (var y = 0; y < 5; y++) {
                    PI_INDEXES[x + 5 * y] = y + ((2 * x + 3 * y) % 5) * 5;
                }
            }

            // Compute round constants
            var LFSR = 0x01;
            for (var i = 0; i < 24; i++) {
                var roundConstantMsw = 0;
                var roundConstantLsw = 0;

                for (var j = 0; j < 7; j++) {
                    if (LFSR & 0x01) {
                        var bitPosition = (1 << j) - 1;
                        if (bitPosition < 32) {
                            roundConstantLsw ^= 1 << bitPosition;
                        } else /* if (bitPosition >= 32) */ {
                            roundConstantMsw ^= 1 << (bitPosition - 32);
                        }
                    }

                    // Compute next LFSR
                    if (LFSR & 0x80) {
                        // Primitive polynomial over GF(2): x^8 + x^6 + x^5 + x^4 + 1
                        LFSR = (LFSR << 1) ^ 0x71;
                    } else {
                        LFSR <<= 1;
                    }
                }

                ROUND_CONSTANTS[i] = X64Word.create(roundConstantMsw, roundConstantLsw);
            }
        }());

        // Reusable objects for temporary values
        var T = [];
        (function () {
            for (var i = 0; i < 25; i++) {
                T[i] = X64Word.create();
            }
        }());

        /**
         * SHA-3 hash algorithm.
         */
        var SHA3 = C_algo.SHA3 = Hasher.extend({
            /**
             * Configuration options.
             *
             * @property {number} outputLength
             *   The desired number of bits in the output hash.
             *   Only values permitted are: 224, 256, 384, 512.
             *   Default: 512
             */
            cfg: Hasher.cfg.extend({
                outputLength: 512
            }),

            _doReset: function () {
                var state = this._state = []
                for (var i = 0; i < 25; i++) {
                    state[i] = new X64Word.init();
                }

                this.blockSize = (1600 - 2 * this.cfg.outputLength) / 32;
            },

            _doProcessBlock: function (M, offset) {
                // Shortcuts
                var state = this._state;
                var nBlockSizeLanes = this.blockSize / 2;

                // Absorb
                for (var i = 0; i < nBlockSizeLanes; i++) {
                    // Shortcuts
                    var M2i  = M[offset + 2 * i];
                    var M2i1 = M[offset + 2 * i + 1];

                    // Swap endian
                    M2i = (
                        (((M2i << 8)  | (M2i >>> 24)) & 0x00ff00ff) |
                        (((M2i << 24) | (M2i >>> 8))  & 0xff00ff00)
                    );
                    M2i1 = (
                        (((M2i1 << 8)  | (M2i1 >>> 24)) & 0x00ff00ff) |
                        (((M2i1 << 24) | (M2i1 >>> 8))  & 0xff00ff00)
                    );

                    // Absorb message into state
                    var lane = state[i];
                    lane.high ^= M2i1;
                    lane.low  ^= M2i;
                }

                // Rounds
                for (var round = 0; round < 24; round++) {
                    // Theta
                    for (var x = 0; x < 5; x++) {
                        // Mix column lanes
                        var tMsw = 0, tLsw = 0;
                        for (var y = 0; y < 5; y++) {
                            var lane = state[x + 5 * y];
                            tMsw ^= lane.high;
                            tLsw ^= lane.low;
                        }

                        // Temporary values
                        var Tx = T[x];
                        Tx.high = tMsw;
                        Tx.low  = tLsw;
                    }
                    for (var x = 0; x < 5; x++) {
                        // Shortcuts
                        var Tx4 = T[(x + 4) % 5];
                        var Tx1 = T[(x + 1) % 5];
                        var Tx1Msw = Tx1.high;
                        var Tx1Lsw = Tx1.low;

                        // Mix surrounding columns
                        var tMsw = Tx4.high ^ ((Tx1Msw << 1) | (Tx1Lsw >>> 31));
                        var tLsw = Tx4.low  ^ ((Tx1Lsw << 1) | (Tx1Msw >>> 31));
                        for (var y = 0; y < 5; y++) {
                            var lane = state[x + 5 * y];
                            lane.high ^= tMsw;
                            lane.low  ^= tLsw;
                        }
                    }

                    // Rho Pi
                    for (var laneIndex = 1; laneIndex < 25; laneIndex++) {
                        // Shortcuts
                        var lane = state[laneIndex];
                        var laneMsw = lane.high;
                        var laneLsw = lane.low;
                        var rhoOffset = RHO_OFFSETS[laneIndex];

                        // Rotate lanes
                        if (rhoOffset < 32) {
                            var tMsw = (laneMsw << rhoOffset) | (laneLsw >>> (32 - rhoOffset));
                            var tLsw = (laneLsw << rhoOffset) | (laneMsw >>> (32 - rhoOffset));
                        } else /* if (rhoOffset >= 32) */ {
                            var tMsw = (laneLsw << (rhoOffset - 32)) | (laneMsw >>> (64 - rhoOffset));
                            var tLsw = (laneMsw << (rhoOffset - 32)) | (laneLsw >>> (64 - rhoOffset));
                        }

                        // Transpose lanes
                        var TPiLane = T[PI_INDEXES[laneIndex]];
                        TPiLane.high = tMsw;
                        TPiLane.low  = tLsw;
                    }

                    // Rho pi at x = y = 0
                    var T0 = T[0];
                    var state0 = state[0];
                    T0.high = state0.high;
                    T0.low  = state0.low;

                    // Chi
                    for (var x = 0; x < 5; x++) {
                        for (var y = 0; y < 5; y++) {
                            // Shortcuts
                            var laneIndex = x + 5 * y;
                            var lane = state[laneIndex];
                            var TLane = T[laneIndex];
                            var Tx1Lane = T[((x + 1) % 5) + 5 * y];
                            var Tx2Lane = T[((x + 2) % 5) + 5 * y];

                            // Mix rows
                            lane.high = TLane.high ^ (~Tx1Lane.high & Tx2Lane.high);
                            lane.low  = TLane.low  ^ (~Tx1Lane.low  & Tx2Lane.low);
                        }
                    }

                    // Iota
                    var lane = state[0];
                    var roundConstant = ROUND_CONSTANTS[round];
                    lane.high ^= roundConstant.high;
                    lane.low  ^= roundConstant.low;;
                }
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;
                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;
                var blockSizeBits = this.blockSize * 32;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x1 << (24 - nBitsLeft % 32);
                dataWords[((Math.ceil((nBitsLeft + 1) / blockSizeBits) * blockSizeBits) >>> 5) - 1] |= 0x80;
                data.sigBytes = dataWords.length * 4;

                // Hash final blocks
                this._process();

                // Shortcuts
                var state = this._state;
                var outputLengthBytes = this.cfg.outputLength / 8;
                var outputLengthLanes = outputLengthBytes / 8;

                // Squeeze
                var hashWords = [];
                for (var i = 0; i < outputLengthLanes; i++) {
                    // Shortcuts
                    var lane = state[i];
                    var laneMsw = lane.high;
                    var laneLsw = lane.low;

                    // Swap endian
                    laneMsw = (
                        (((laneMsw << 8)  | (laneMsw >>> 24)) & 0x00ff00ff) |
                        (((laneMsw << 24) | (laneMsw >>> 8))  & 0xff00ff00)
                    );
                    laneLsw = (
                        (((laneLsw << 8)  | (laneLsw >>> 24)) & 0x00ff00ff) |
                        (((laneLsw << 24) | (laneLsw >>> 8))  & 0xff00ff00)
                    );

                    // Squeeze state to retrieve hash
                    hashWords.push(laneLsw);
                    hashWords.push(laneMsw);
                }

                // Return final computed hash
                return new WordArray.init(hashWords, outputLengthBytes);
            },

            clone: function () {
                var clone = Hasher.clone.call(this);

                var state = clone._state = this._state.slice(0);
                for (var i = 0; i < 25; i++) {
                    state[i] = state[i].clone();
                }

                return clone;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA3('message');
         *     var hash = CryptoJS.SHA3(wordArray);
         */
        C.SHA3 = Hasher._createHelper(SHA3);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA3(message, key);
         */
        C.HmacSHA3 = Hasher._createHmacHelper(SHA3);
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Hasher = C_lib.Hasher;
        var C_x64 = C.x64;
        var X64Word = C_x64.Word;
        var X64WordArray = C_x64.WordArray;
        var C_algo = C.algo;

        function X64Word_create() {
            return X64Word.create.apply(X64Word, arguments);
        }

        // Constants
        var K = [
            X64Word_create(0x428a2f98, 0xd728ae22), X64Word_create(0x71374491, 0x23ef65cd),
            X64Word_create(0xb5c0fbcf, 0xec4d3b2f), X64Word_create(0xe9b5dba5, 0x8189dbbc),
            X64Word_create(0x3956c25b, 0xf348b538), X64Word_create(0x59f111f1, 0xb605d019),
            X64Word_create(0x923f82a4, 0xaf194f9b), X64Word_create(0xab1c5ed5, 0xda6d8118),
            X64Word_create(0xd807aa98, 0xa3030242), X64Word_create(0x12835b01, 0x45706fbe),
            X64Word_create(0x243185be, 0x4ee4b28c), X64Word_create(0x550c7dc3, 0xd5ffb4e2),
            X64Word_create(0x72be5d74, 0xf27b896f), X64Word_create(0x80deb1fe, 0x3b1696b1),
            X64Word_create(0x9bdc06a7, 0x25c71235), X64Word_create(0xc19bf174, 0xcf692694),
            X64Word_create(0xe49b69c1, 0x9ef14ad2), X64Word_create(0xefbe4786, 0x384f25e3),
            X64Word_create(0x0fc19dc6, 0x8b8cd5b5), X64Word_create(0x240ca1cc, 0x77ac9c65),
            X64Word_create(0x2de92c6f, 0x592b0275), X64Word_create(0x4a7484aa, 0x6ea6e483),
            X64Word_create(0x5cb0a9dc, 0xbd41fbd4), X64Word_create(0x76f988da, 0x831153b5),
            X64Word_create(0x983e5152, 0xee66dfab), X64Word_create(0xa831c66d, 0x2db43210),
            X64Word_create(0xb00327c8, 0x98fb213f), X64Word_create(0xbf597fc7, 0xbeef0ee4),
            X64Word_create(0xc6e00bf3, 0x3da88fc2), X64Word_create(0xd5a79147, 0x930aa725),
            X64Word_create(0x06ca6351, 0xe003826f), X64Word_create(0x14292967, 0x0a0e6e70),
            X64Word_create(0x27b70a85, 0x46d22ffc), X64Word_create(0x2e1b2138, 0x5c26c926),
            X64Word_create(0x4d2c6dfc, 0x5ac42aed), X64Word_create(0x53380d13, 0x9d95b3df),
            X64Word_create(0x650a7354, 0x8baf63de), X64Word_create(0x766a0abb, 0x3c77b2a8),
            X64Word_create(0x81c2c92e, 0x47edaee6), X64Word_create(0x92722c85, 0x1482353b),
            X64Word_create(0xa2bfe8a1, 0x4cf10364), X64Word_create(0xa81a664b, 0xbc423001),
            X64Word_create(0xc24b8b70, 0xd0f89791), X64Word_create(0xc76c51a3, 0x0654be30),
            X64Word_create(0xd192e819, 0xd6ef5218), X64Word_create(0xd6990624, 0x5565a910),
            X64Word_create(0xf40e3585, 0x5771202a), X64Word_create(0x106aa070, 0x32bbd1b8),
            X64Word_create(0x19a4c116, 0xb8d2d0c8), X64Word_create(0x1e376c08, 0x5141ab53),
            X64Word_create(0x2748774c, 0xdf8eeb99), X64Word_create(0x34b0bcb5, 0xe19b48a8),
            X64Word_create(0x391c0cb3, 0xc5c95a63), X64Word_create(0x4ed8aa4a, 0xe3418acb),
            X64Word_create(0x5b9cca4f, 0x7763e373), X64Word_create(0x682e6ff3, 0xd6b2b8a3),
            X64Word_create(0x748f82ee, 0x5defb2fc), X64Word_create(0x78a5636f, 0x43172f60),
            X64Word_create(0x84c87814, 0xa1f0ab72), X64Word_create(0x8cc70208, 0x1a6439ec),
            X64Word_create(0x90befffa, 0x23631e28), X64Word_create(0xa4506ceb, 0xde82bde9),
            X64Word_create(0xbef9a3f7, 0xb2c67915), X64Word_create(0xc67178f2, 0xe372532b),
            X64Word_create(0xca273ece, 0xea26619c), X64Word_create(0xd186b8c7, 0x21c0c207),
            X64Word_create(0xeada7dd6, 0xcde0eb1e), X64Word_create(0xf57d4f7f, 0xee6ed178),
            X64Word_create(0x06f067aa, 0x72176fba), X64Word_create(0x0a637dc5, 0xa2c898a6),
            X64Word_create(0x113f9804, 0xbef90dae), X64Word_create(0x1b710b35, 0x131c471b),
            X64Word_create(0x28db77f5, 0x23047d84), X64Word_create(0x32caab7b, 0x40c72493),
            X64Word_create(0x3c9ebe0a, 0x15c9bebc), X64Word_create(0x431d67c4, 0x9c100d4c),
            X64Word_create(0x4cc5d4be, 0xcb3e42b6), X64Word_create(0x597f299c, 0xfc657e2a),
            X64Word_create(0x5fcb6fab, 0x3ad6faec), X64Word_create(0x6c44198c, 0x4a475817)
        ];

        // Reusable objects
        var W = [];
        (function () {
            for (var i = 0; i < 80; i++) {
                W[i] = X64Word_create();
            }
        }());

        /**
         * SHA-512 hash algorithm.
         */
        var SHA512 = C_algo.SHA512 = Hasher.extend({
            _doReset: function () {
                this._hash = new X64WordArray.init([
                    new X64Word.init(0x6a09e667, 0xf3bcc908), new X64Word.init(0xbb67ae85, 0x84caa73b),
                    new X64Word.init(0x3c6ef372, 0xfe94f82b), new X64Word.init(0xa54ff53a, 0x5f1d36f1),
                    new X64Word.init(0x510e527f, 0xade682d1), new X64Word.init(0x9b05688c, 0x2b3e6c1f),
                    new X64Word.init(0x1f83d9ab, 0xfb41bd6b), new X64Word.init(0x5be0cd19, 0x137e2179)
                ]);
            },

            _doProcessBlock: function (M, offset) {
                // Shortcuts
                var H = this._hash.words;

                var H0 = H[0];
                var H1 = H[1];
                var H2 = H[2];
                var H3 = H[3];
                var H4 = H[4];
                var H5 = H[5];
                var H6 = H[6];
                var H7 = H[7];

                var H0h = H0.high;
                var H0l = H0.low;
                var H1h = H1.high;
                var H1l = H1.low;
                var H2h = H2.high;
                var H2l = H2.low;
                var H3h = H3.high;
                var H3l = H3.low;
                var H4h = H4.high;
                var H4l = H4.low;
                var H5h = H5.high;
                var H5l = H5.low;
                var H6h = H6.high;
                var H6l = H6.low;
                var H7h = H7.high;
                var H7l = H7.low;

                // Working variables
                var ah = H0h;
                var al = H0l;
                var bh = H1h;
                var bl = H1l;
                var ch = H2h;
                var cl = H2l;
                var dh = H3h;
                var dl = H3l;
                var eh = H4h;
                var el = H4l;
                var fh = H5h;
                var fl = H5l;
                var gh = H6h;
                var gl = H6l;
                var hh = H7h;
                var hl = H7l;

                // Rounds
                for (var i = 0; i < 80; i++) {
                    // Shortcut
                    var Wi = W[i];

                    // Extend message
                    if (i < 16) {
                        var Wih = Wi.high = M[offset + i * 2]     | 0;
                        var Wil = Wi.low  = M[offset + i * 2 + 1] | 0;
                    } else {
                        // Gamma0
                        var gamma0x  = W[i - 15];
                        var gamma0xh = gamma0x.high;
                        var gamma0xl = gamma0x.low;
                        var gamma0h  = ((gamma0xh >>> 1) | (gamma0xl << 31)) ^ ((gamma0xh >>> 8) | (gamma0xl << 24)) ^ (gamma0xh >>> 7);
                        var gamma0l  = ((gamma0xl >>> 1) | (gamma0xh << 31)) ^ ((gamma0xl >>> 8) | (gamma0xh << 24)) ^ ((gamma0xl >>> 7) | (gamma0xh << 25));

                        // Gamma1
                        var gamma1x  = W[i - 2];
                        var gamma1xh = gamma1x.high;
                        var gamma1xl = gamma1x.low;
                        var gamma1h  = ((gamma1xh >>> 19) | (gamma1xl << 13)) ^ ((gamma1xh << 3) | (gamma1xl >>> 29)) ^ (gamma1xh >>> 6);
                        var gamma1l  = ((gamma1xl >>> 19) | (gamma1xh << 13)) ^ ((gamma1xl << 3) | (gamma1xh >>> 29)) ^ ((gamma1xl >>> 6) | (gamma1xh << 26));

                        // W[i] = gamma0 + W[i - 7] + gamma1 + W[i - 16]
                        var Wi7  = W[i - 7];
                        var Wi7h = Wi7.high;
                        var Wi7l = Wi7.low;

                        var Wi16  = W[i - 16];
                        var Wi16h = Wi16.high;
                        var Wi16l = Wi16.low;

                        var Wil = gamma0l + Wi7l;
                        var Wih = gamma0h + Wi7h + ((Wil >>> 0) < (gamma0l >>> 0) ? 1 : 0);
                        var Wil = Wil + gamma1l;
                        var Wih = Wih + gamma1h + ((Wil >>> 0) < (gamma1l >>> 0) ? 1 : 0);
                        var Wil = Wil + Wi16l;
                        var Wih = Wih + Wi16h + ((Wil >>> 0) < (Wi16l >>> 0) ? 1 : 0);

                        Wi.high = Wih;
                        Wi.low  = Wil;
                    }

                    var chh  = (eh & fh) ^ (~eh & gh);
                    var chl  = (el & fl) ^ (~el & gl);
                    var majh = (ah & bh) ^ (ah & ch) ^ (bh & ch);
                    var majl = (al & bl) ^ (al & cl) ^ (bl & cl);

                    var sigma0h = ((ah >>> 28) | (al << 4))  ^ ((ah << 30)  | (al >>> 2)) ^ ((ah << 25) | (al >>> 7));
                    var sigma0l = ((al >>> 28) | (ah << 4))  ^ ((al << 30)  | (ah >>> 2)) ^ ((al << 25) | (ah >>> 7));
                    var sigma1h = ((eh >>> 14) | (el << 18)) ^ ((eh >>> 18) | (el << 14)) ^ ((eh << 23) | (el >>> 9));
                    var sigma1l = ((el >>> 14) | (eh << 18)) ^ ((el >>> 18) | (eh << 14)) ^ ((el << 23) | (eh >>> 9));

                    // t1 = h + sigma1 + ch + K[i] + W[i]
                    var Ki  = K[i];
                    var Kih = Ki.high;
                    var Kil = Ki.low;

                    var t1l = hl + sigma1l;
                    var t1h = hh + sigma1h + ((t1l >>> 0) < (hl >>> 0) ? 1 : 0);
                    var t1l = t1l + chl;
                    var t1h = t1h + chh + ((t1l >>> 0) < (chl >>> 0) ? 1 : 0);
                    var t1l = t1l + Kil;
                    var t1h = t1h + Kih + ((t1l >>> 0) < (Kil >>> 0) ? 1 : 0);
                    var t1l = t1l + Wil;
                    var t1h = t1h + Wih + ((t1l >>> 0) < (Wil >>> 0) ? 1 : 0);

                    // t2 = sigma0 + maj
                    var t2l = sigma0l + majl;
                    var t2h = sigma0h + majh + ((t2l >>> 0) < (sigma0l >>> 0) ? 1 : 0);

                    // Update working variables
                    hh = gh;
                    hl = gl;
                    gh = fh;
                    gl = fl;
                    fh = eh;
                    fl = el;
                    el = (dl + t1l) | 0;
                    eh = (dh + t1h + ((el >>> 0) < (dl >>> 0) ? 1 : 0)) | 0;
                    dh = ch;
                    dl = cl;
                    ch = bh;
                    cl = bl;
                    bh = ah;
                    bl = al;
                    al = (t1l + t2l) | 0;
                    ah = (t1h + t2h + ((al >>> 0) < (t1l >>> 0) ? 1 : 0)) | 0;
                }

                // Intermediate hash value
                H0l = H0.low  = (H0l + al);
                H0.high = (H0h + ah + ((H0l >>> 0) < (al >>> 0) ? 1 : 0));
                H1l = H1.low  = (H1l + bl);
                H1.high = (H1h + bh + ((H1l >>> 0) < (bl >>> 0) ? 1 : 0));
                H2l = H2.low  = (H2l + cl);
                H2.high = (H2h + ch + ((H2l >>> 0) < (cl >>> 0) ? 1 : 0));
                H3l = H3.low  = (H3l + dl);
                H3.high = (H3h + dh + ((H3l >>> 0) < (dl >>> 0) ? 1 : 0));
                H4l = H4.low  = (H4l + el);
                H4.high = (H4h + eh + ((H4l >>> 0) < (el >>> 0) ? 1 : 0));
                H5l = H5.low  = (H5l + fl);
                H5.high = (H5h + fh + ((H5l >>> 0) < (fl >>> 0) ? 1 : 0));
                H6l = H6.low  = (H6l + gl);
                H6.high = (H6h + gh + ((H6l >>> 0) < (gl >>> 0) ? 1 : 0));
                H7l = H7.low  = (H7l + hl);
                H7.high = (H7h + hh + ((H7l >>> 0) < (hl >>> 0) ? 1 : 0));
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);
                dataWords[(((nBitsLeft + 128) >>> 10) << 5) + 30] = Math.floor(nBitsTotal / 0x100000000);
                dataWords[(((nBitsLeft + 128) >>> 10) << 5) + 31] = nBitsTotal;
                data.sigBytes = dataWords.length * 4;

                // Hash final blocks
                this._process();

                // Convert hash to 32-bit word array before returning
                var hash = this._hash.toX32();

                // Return final computed hash
                return hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            },

            blockSize: 1024/32
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA512('message');
         *     var hash = CryptoJS.SHA512(wordArray);
         */
        C.SHA512 = Hasher._createHelper(SHA512);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA512(message, key);
         */
        C.HmacSHA512 = Hasher._createHmacHelper(SHA512);
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_x64 = C.x64;
        var X64Word = C_x64.Word;
        var X64WordArray = C_x64.WordArray;
        var C_algo = C.algo;
        var SHA512 = C_algo.SHA512;

        /**
         * SHA-384 hash algorithm.
         */
        var SHA384 = C_algo.SHA384 = SHA512.extend({
            _doReset: function () {
                this._hash = new X64WordArray.init([
                    new X64Word.init(0xcbbb9d5d, 0xc1059ed8), new X64Word.init(0x629a292a, 0x367cd507),
                    new X64Word.init(0x9159015a, 0x3070dd17), new X64Word.init(0x152fecd8, 0xf70e5939),
                    new X64Word.init(0x67332667, 0xffc00b31), new X64Word.init(0x8eb44a87, 0x68581511),
                    new X64Word.init(0xdb0c2e0d, 0x64f98fa7), new X64Word.init(0x47b5481d, 0xbefa4fa4)
                ]);
            },

            _doFinalize: function () {
                var hash = SHA512._doFinalize.call(this);

                hash.sigBytes -= 16;

                return hash;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA384('message');
         *     var hash = CryptoJS.SHA384(wordArray);
         */
        C.SHA384 = SHA512._createHelper(SHA384);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA384(message, key);
         */
        C.HmacSHA384 = SHA512._createHmacHelper(SHA384);
    }());


    /**
     * Cipher core components.
     */
    CryptoJS.lib.Cipher || (function (undefined) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var WordArray = C_lib.WordArray;
        var BufferedBlockAlgorithm = C_lib.BufferedBlockAlgorithm;
        var C_enc = C.enc;
        var Utf8 = C_enc.Utf8;
        var Base64 = C_enc.Base64;
        var C_algo = C.algo;
        var EvpKDF = C_algo.EvpKDF;

        /**
         * Abstract base cipher template.
         *
         * @property {number} keySize This cipher's key size. Default: 4 (128 bits)
         * @property {number} ivSize This cipher's IV size. Default: 4 (128 bits)
         * @property {number} _ENC_XFORM_MODE A constant representing encryption mode.
         * @property {number} _DEC_XFORM_MODE A constant representing decryption mode.
         */
        var Cipher = C_lib.Cipher = BufferedBlockAlgorithm.extend({
            /**
             * Configuration options.
             *
             * @property {WordArray} iv The IV to use for this operation.
             */
            cfg: Base.extend(),

            /**
             * Creates this cipher in encryption mode.
             *
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {Cipher} A cipher instance.
             *
             * @static
             *
             * @example
             *
             *     var cipher = CryptoJS.algo.AES.createEncryptor(keyWordArray, { iv: ivWordArray });
             */
            createEncryptor: function (key, cfg) {
                return this.create(this._ENC_XFORM_MODE, key, cfg);
            },

            /**
             * Creates this cipher in decryption mode.
             *
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {Cipher} A cipher instance.
             *
             * @static
             *
             * @example
             *
             *     var cipher = CryptoJS.algo.AES.createDecryptor(keyWordArray, { iv: ivWordArray });
             */
            createDecryptor: function (key, cfg) {
                return this.create(this._DEC_XFORM_MODE, key, cfg);
            },

            /**
             * Initializes a newly created cipher.
             *
             * @param {number} xformMode Either the encryption or decryption transormation mode constant.
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @example
             *
             *     var cipher = CryptoJS.algo.AES.create(CryptoJS.algo.AES._ENC_XFORM_MODE, keyWordArray, { iv: ivWordArray });
             */
            init: function (xformMode, key, cfg) {
                // Apply config defaults
                this.cfg = this.cfg.extend(cfg);

                // Store transform mode and key
                this._xformMode = xformMode;
                this._key = key;

                // Set initial values
                this.reset();
            },

            /**
             * Resets this cipher to its initial state.
             *
             * @example
             *
             *     cipher.reset();
             */
            reset: function () {
                // Reset data buffer
                BufferedBlockAlgorithm.reset.call(this);

                // Perform concrete-cipher logic
                this._doReset();
            },

            /**
             * Adds data to be encrypted or decrypted.
             *
             * @param {WordArray|string} dataUpdate The data to encrypt or decrypt.
             *
             * @return {WordArray} The data after processing.
             *
             * @example
             *
             *     var encrypted = cipher.process('data');
             *     var encrypted = cipher.process(wordArray);
             */
            process: function (dataUpdate) {
                // Append
                this._append(dataUpdate);

                // Process available blocks
                return this._process();
            },

            /**
             * Finalizes the encryption or decryption process.
             * Note that the finalize operation is effectively a destructive, read-once operation.
             *
             * @param {WordArray|string} dataUpdate The final data to encrypt or decrypt.
             *
             * @return {WordArray} The data after final processing.
             *
             * @example
             *
             *     var encrypted = cipher.finalize();
             *     var encrypted = cipher.finalize('data');
             *     var encrypted = cipher.finalize(wordArray);
             */
            finalize: function (dataUpdate) {
                // Final data update
                if (dataUpdate) {
                    this._append(dataUpdate);
                }

                // Perform concrete-cipher logic
                var finalProcessedData = this._doFinalize();

                return finalProcessedData;
            },

            keySize: 128/32,

            ivSize: 128/32,

            _ENC_XFORM_MODE: 1,

            _DEC_XFORM_MODE: 2,

            /**
             * Creates shortcut functions to a cipher's object interface.
             *
             * @param {Cipher} cipher The cipher to create a helper for.
             *
             * @return {Object} An object with encrypt and decrypt shortcut functions.
             *
             * @static
             *
             * @example
             *
             *     var AES = CryptoJS.lib.Cipher._createHelper(CryptoJS.algo.AES);
             */
            _createHelper: (function () {
                function selectCipherStrategy(key) {
                    if (typeof key == 'string') {
                        return PasswordBasedCipher;
                    } else {
                        return SerializableCipher;
                    }
                }

                return function (cipher) {
                    return {
                        encrypt: function (message, key, cfg) {
                            return selectCipherStrategy(key).encrypt(cipher, message, key, cfg);
                        },

                        decrypt: function (ciphertext, key, cfg) {
                            return selectCipherStrategy(key).decrypt(cipher, ciphertext, key, cfg);
                        }
                    };
                };
            }())
        });

        /**
         * Abstract base stream cipher template.
         *
         * @property {number} blockSize The number of 32-bit words this cipher operates on. Default: 1 (32 bits)
         */
        var StreamCipher = C_lib.StreamCipher = Cipher.extend({
            _doFinalize: function () {
                // Process partial blocks
                var finalProcessedBlocks = this._process(!!'flush');

                return finalProcessedBlocks;
            },

            blockSize: 1
        });

        /**
         * Mode namespace.
         */
        var C_mode = C.mode = {};

        /**
         * Abstract base block cipher mode template.
         */
        var BlockCipherMode = C_lib.BlockCipherMode = Base.extend({
            /**
             * Creates this mode for encryption.
             *
             * @param {Cipher} cipher A block cipher instance.
             * @param {Array} iv The IV words.
             *
             * @static
             *
             * @example
             *
             *     var mode = CryptoJS.mode.CBC.createEncryptor(cipher, iv.words);
             */
            createEncryptor: function (cipher, iv) {
                return this.Encryptor.create(cipher, iv);
            },

            /**
             * Creates this mode for decryption.
             *
             * @param {Cipher} cipher A block cipher instance.
             * @param {Array} iv The IV words.
             *
             * @static
             *
             * @example
             *
             *     var mode = CryptoJS.mode.CBC.createDecryptor(cipher, iv.words);
             */
            createDecryptor: function (cipher, iv) {
                return this.Decryptor.create(cipher, iv);
            },

            /**
             * Initializes a newly created mode.
             *
             * @param {Cipher} cipher A block cipher instance.
             * @param {Array} iv The IV words.
             *
             * @example
             *
             *     var mode = CryptoJS.mode.CBC.Encryptor.create(cipher, iv.words);
             */
            init: function (cipher, iv) {
                this._cipher = cipher;
                this._iv = iv;
            }
        });

        /**
         * Cipher Block Chaining mode.
         */
        var CBC = C_mode.CBC = (function () {
            /**
             * Abstract base CBC mode.
             */
            var CBC = BlockCipherMode.extend();

            /**
             * CBC encryptor.
             */
            CBC.Encryptor = CBC.extend({
                /**
                 * Processes the data block at offset.
                 *
                 * @param {Array} words The data words to operate on.
                 * @param {number} offset The offset where the block starts.
                 *
                 * @example
                 *
                 *     mode.processBlock(data.words, offset);
                 */
                processBlock: function (words, offset) {
                    // Shortcuts
                    var cipher = this._cipher;
                    var blockSize = cipher.blockSize;

                    // XOR and encrypt
                    xorBlock.call(this, words, offset, blockSize);
                    cipher.encryptBlock(words, offset);

                    // Remember this block to use with next block
                    this._prevBlock = words.slice(offset, offset + blockSize);
                }
            });

            /**
             * CBC decryptor.
             */
            CBC.Decryptor = CBC.extend({
                /**
                 * Processes the data block at offset.
                 *
                 * @param {Array} words The data words to operate on.
                 * @param {number} offset The offset where the block starts.
                 *
                 * @example
                 *
                 *     mode.processBlock(data.words, offset);
                 */
                processBlock: function (words, offset) {
                    // Shortcuts
                    var cipher = this._cipher;
                    var blockSize = cipher.blockSize;

                    // Remember this block to use with next block
                    var thisBlock = words.slice(offset, offset + blockSize);

                    // Decrypt and XOR
                    cipher.decryptBlock(words, offset);
                    xorBlock.call(this, words, offset, blockSize);

                    // This block becomes the previous block
                    this._prevBlock = thisBlock;
                }
            });

            function xorBlock(words, offset, blockSize) {
                // Shortcut
                var iv = this._iv;

                // Choose mixing block
                if (iv) {
                    var block = iv;

                    // Remove IV for subsequent blocks
                    this._iv = undefined;
                } else {
                    var block = this._prevBlock;
                }

                // XOR blocks
                for (var i = 0; i < blockSize; i++) {
                    words[offset + i] ^= block[i];
                }
            }

            return CBC;
        }());

        /**
         * Padding namespace.
         */
        var C_pad = C.pad = {};

        /**
         * PKCS #5/7 padding strategy.
         */
        var Pkcs7 = C_pad.Pkcs7 = {
            /**
             * Pads data using the algorithm defined in PKCS #5/7.
             *
             * @param {WordArray} data The data to pad.
             * @param {number} blockSize The multiple that the data should be padded to.
             *
             * @static
             *
             * @example
             *
             *     CryptoJS.pad.Pkcs7.pad(wordArray, 4);
             */
            pad: function (data, blockSize) {
                // Shortcut
                var blockSizeBytes = blockSize * 4;

                // Count padding bytes
                var nPaddingBytes = blockSizeBytes - data.sigBytes % blockSizeBytes;

                // Create padding word
                var paddingWord = (nPaddingBytes << 24) | (nPaddingBytes << 16) | (nPaddingBytes << 8) | nPaddingBytes;

                // Create padding
                var paddingWords = [];
                for (var i = 0; i < nPaddingBytes; i += 4) {
                    paddingWords.push(paddingWord);
                }
                var padding = WordArray.create(paddingWords, nPaddingBytes);

                // Add padding
                data.concat(padding);
            },

            /**
             * Unpads data that had been padded using the algorithm defined in PKCS #5/7.
             *
             * @param {WordArray} data The data to unpad.
             *
             * @static
             *
             * @example
             *
             *     CryptoJS.pad.Pkcs7.unpad(wordArray);
             */
            unpad: function (data) {
                // Get number of padding bytes from last byte
                var nPaddingBytes = data.words[(data.sigBytes - 1) >>> 2] & 0xff;

                // Remove padding
                data.sigBytes -= nPaddingBytes;
            }
        };

        /**
         * Abstract base block cipher template.
         *
         * @property {number} blockSize The number of 32-bit words this cipher operates on. Default: 4 (128 bits)
         */
        var BlockCipher = C_lib.BlockCipher = Cipher.extend({
            /**
             * Configuration options.
             *
             * @property {Mode} mode The block mode to use. Default: CBC
             * @property {Padding} padding The padding strategy to use. Default: Pkcs7
             */
            cfg: Cipher.cfg.extend({
                mode: CBC,
                padding: Pkcs7
            }),

            reset: function () {
                // Reset cipher
                Cipher.reset.call(this);

                // Shortcuts
                var cfg = this.cfg;
                var iv = cfg.iv;
                var mode = cfg.mode;

                // Reset block mode
                if (this._xformMode == this._ENC_XFORM_MODE) {
                    var modeCreator = mode.createEncryptor;
                } else /* if (this._xformMode == this._DEC_XFORM_MODE) */ {
                    var modeCreator = mode.createDecryptor;
                    // Keep at least one block in the buffer for unpadding
                    this._minBufferSize = 1;
                }

                if (this._mode && this._mode.__creator == modeCreator) {
                    this._mode.init(this, iv && iv.words);
                } else {
                    this._mode = modeCreator.call(mode, this, iv && iv.words);
                    this._mode.__creator = modeCreator;
                }
            },

            _doProcessBlock: function (words, offset) {
                this._mode.processBlock(words, offset);
            },

            _doFinalize: function () {
                // Shortcut
                var padding = this.cfg.padding;

                // Finalize
                if (this._xformMode == this._ENC_XFORM_MODE) {
                    // Pad data
                    padding.pad(this._data, this.blockSize);

                    // Process final blocks
                    var finalProcessedBlocks = this._process(!!'flush');
                } else /* if (this._xformMode == this._DEC_XFORM_MODE) */ {
                    // Process final blocks
                    var finalProcessedBlocks = this._process(!!'flush');

                    // Unpad data
                    padding.unpad(finalProcessedBlocks);
                }

                return finalProcessedBlocks;
            },

            blockSize: 128/32
        });

        /**
         * A collection of cipher parameters.
         *
         * @property {WordArray} ciphertext The raw ciphertext.
         * @property {WordArray} key The key to this ciphertext.
         * @property {WordArray} iv The IV used in the ciphering operation.
         * @property {WordArray} salt The salt used with a key derivation function.
         * @property {Cipher} algorithm The cipher algorithm.
         * @property {Mode} mode The block mode used in the ciphering operation.
         * @property {Padding} padding The padding scheme used in the ciphering operation.
         * @property {number} blockSize The block size of the cipher.
         * @property {Format} formatter The default formatting strategy to convert this cipher params object to a string.
         */
        var CipherParams = C_lib.CipherParams = Base.extend({
            /**
             * Initializes a newly created cipher params object.
             *
             * @param {Object} cipherParams An object with any of the possible cipher parameters.
             *
             * @example
             *
             *     var cipherParams = CryptoJS.lib.CipherParams.create({
	         *         ciphertext: ciphertextWordArray,
	         *         key: keyWordArray,
	         *         iv: ivWordArray,
	         *         salt: saltWordArray,
	         *         algorithm: CryptoJS.algo.AES,
	         *         mode: CryptoJS.mode.CBC,
	         *         padding: CryptoJS.pad.PKCS7,
	         *         blockSize: 4,
	         *         formatter: CryptoJS.format.OpenSSL
	         *     });
             */
            init: function (cipherParams) {
                this.mixIn(cipherParams);
            },

            /**
             * Converts this cipher params object to a string.
             *
             * @param {Format} formatter (Optional) The formatting strategy to use.
             *
             * @return {string} The stringified cipher params.
             *
             * @throws Error If neither the formatter nor the default formatter is set.
             *
             * @example
             *
             *     var string = cipherParams + '';
             *     var string = cipherParams.toString();
             *     var string = cipherParams.toString(CryptoJS.format.OpenSSL);
             */
            toString: function (formatter) {
                return (formatter || this.formatter).stringify(this);
            }
        });

        /**
         * Format namespace.
         */
        var C_format = C.format = {};

        /**
         * OpenSSL formatting strategy.
         */
        var OpenSSLFormatter = C_format.OpenSSL = {
            /**
             * Converts a cipher params object to an OpenSSL-compatible string.
             *
             * @param {CipherParams} cipherParams The cipher params object.
             *
             * @return {string} The OpenSSL-compatible string.
             *
             * @static
             *
             * @example
             *
             *     var openSSLString = CryptoJS.format.OpenSSL.stringify(cipherParams);
             */
            stringify: function (cipherParams) {
                // Shortcuts
                var ciphertext = cipherParams.ciphertext;
                var salt = cipherParams.salt;

                // Format
                if (salt) {
                    var wordArray = WordArray.create([0x53616c74, 0x65645f5f]).concat(salt).concat(ciphertext);
                } else {
                    var wordArray = ciphertext;
                }

                return wordArray.toString(Base64);
            },

            /**
             * Converts an OpenSSL-compatible string to a cipher params object.
             *
             * @param {string} openSSLStr The OpenSSL-compatible string.
             *
             * @return {CipherParams} The cipher params object.
             *
             * @static
             *
             * @example
             *
             *     var cipherParams = CryptoJS.format.OpenSSL.parse(openSSLString);
             */
            parse: function (openSSLStr) {
                // Parse base64
                var ciphertext = Base64.parse(openSSLStr);

                // Shortcut
                var ciphertextWords = ciphertext.words;

                // Test for salt
                if (ciphertextWords[0] == 0x53616c74 && ciphertextWords[1] == 0x65645f5f) {
                    // Extract salt
                    var salt = WordArray.create(ciphertextWords.slice(2, 4));

                    // Remove salt from ciphertext
                    ciphertextWords.splice(0, 4);
                    ciphertext.sigBytes -= 16;
                }

                return CipherParams.create({ ciphertext: ciphertext, salt: salt });
            }
        };

        /**
         * A cipher wrapper that returns ciphertext as a serializable cipher params object.
         */
        var SerializableCipher = C_lib.SerializableCipher = Base.extend({
            /**
             * Configuration options.
             *
             * @property {Formatter} format The formatting strategy to convert cipher param objects to and from a string. Default: OpenSSL
             */
            cfg: Base.extend({
                format: OpenSSLFormatter
            }),

            /**
             * Encrypts a message.
             *
             * @param {Cipher} cipher The cipher algorithm to use.
             * @param {WordArray|string} message The message to encrypt.
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {CipherParams} A cipher params object.
             *
             * @static
             *
             * @example
             *
             *     var ciphertextParams = CryptoJS.lib.SerializableCipher.encrypt(CryptoJS.algo.AES, message, key);
             *     var ciphertextParams = CryptoJS.lib.SerializableCipher.encrypt(CryptoJS.algo.AES, message, key, { iv: iv });
             *     var ciphertextParams = CryptoJS.lib.SerializableCipher.encrypt(CryptoJS.algo.AES, message, key, { iv: iv, format: CryptoJS.format.OpenSSL });
             */
            encrypt: function (cipher, message, key, cfg) {
                // Apply config defaults
                cfg = this.cfg.extend(cfg);

                // Encrypt
                var encryptor = cipher.createEncryptor(key, cfg);
                var ciphertext = encryptor.finalize(message);

                // Shortcut
                var cipherCfg = encryptor.cfg;

                // Create and return serializable cipher params
                return CipherParams.create({
                    ciphertext: ciphertext,
                    key: key,
                    iv: cipherCfg.iv,
                    algorithm: cipher,
                    mode: cipherCfg.mode,
                    padding: cipherCfg.padding,
                    blockSize: cipher.blockSize,
                    formatter: cfg.format
                });
            },

            /**
             * Decrypts serialized ciphertext.
             *
             * @param {Cipher} cipher The cipher algorithm to use.
             * @param {CipherParams|string} ciphertext The ciphertext to decrypt.
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {WordArray} The plaintext.
             *
             * @static
             *
             * @example
             *
             *     var plaintext = CryptoJS.lib.SerializableCipher.decrypt(CryptoJS.algo.AES, formattedCiphertext, key, { iv: iv, format: CryptoJS.format.OpenSSL });
             *     var plaintext = CryptoJS.lib.SerializableCipher.decrypt(CryptoJS.algo.AES, ciphertextParams, key, { iv: iv, format: CryptoJS.format.OpenSSL });
             */
            decrypt: function (cipher, ciphertext, key, cfg) {
                // Apply config defaults
                cfg = this.cfg.extend(cfg);

                // Convert string to CipherParams
                ciphertext = this._parse(ciphertext, cfg.format);

                // Decrypt
                var plaintext = cipher.createDecryptor(key, cfg).finalize(ciphertext.ciphertext);

                return plaintext;
            },

            /**
             * Converts serialized ciphertext to CipherParams,
             * else assumed CipherParams already and returns ciphertext unchanged.
             *
             * @param {CipherParams|string} ciphertext The ciphertext.
             * @param {Formatter} format The formatting strategy to use to parse serialized ciphertext.
             *
             * @return {CipherParams} The unserialized ciphertext.
             *
             * @static
             *
             * @example
             *
             *     var ciphertextParams = CryptoJS.lib.SerializableCipher._parse(ciphertextStringOrParams, format);
             */
            _parse: function (ciphertext, format) {
                if (typeof ciphertext == 'string') {
                    return format.parse(ciphertext, this);
                } else {
                    return ciphertext;
                }
            }
        });

        /**
         * Key derivation function namespace.
         */
        var C_kdf = C.kdf = {};

        /**
         * OpenSSL key derivation function.
         */
        var OpenSSLKdf = C_kdf.OpenSSL = {
            /**
             * Derives a key and IV from a password.
             *
             * @param {string} password The password to derive from.
             * @param {number} keySize The size in words of the key to generate.
             * @param {number} ivSize The size in words of the IV to generate.
             * @param {WordArray|string} salt (Optional) A 64-bit salt to use. If omitted, a salt will be generated randomly.
             *
             * @return {CipherParams} A cipher params object with the key, IV, and salt.
             *
             * @static
             *
             * @example
             *
             *     var derivedParams = CryptoJS.kdf.OpenSSL.execute('Password', 256/32, 128/32);
             *     var derivedParams = CryptoJS.kdf.OpenSSL.execute('Password', 256/32, 128/32, 'saltsalt');
             */
            execute: function (password, keySize, ivSize, salt) {
                // Generate random salt
                if (!salt) {
                    salt = WordArray.random(64/8);
                }

                // Derive key and IV
                var key = EvpKDF.create({ keySize: keySize + ivSize }).compute(password, salt);

                // Separate key and IV
                var iv = WordArray.create(key.words.slice(keySize), ivSize * 4);
                key.sigBytes = keySize * 4;

                // Return params
                return CipherParams.create({ key: key, iv: iv, salt: salt });
            }
        };

        /**
         * A serializable cipher wrapper that derives the key from a password,
         * and returns ciphertext as a serializable cipher params object.
         */
        var PasswordBasedCipher = C_lib.PasswordBasedCipher = SerializableCipher.extend({
            /**
             * Configuration options.
             *
             * @property {KDF} kdf The key derivation function to use to generate a key and IV from a password. Default: OpenSSL
             */
            cfg: SerializableCipher.cfg.extend({
                kdf: OpenSSLKdf
            }),

            /**
             * Encrypts a message using a password.
             *
             * @param {Cipher} cipher The cipher algorithm to use.
             * @param {WordArray|string} message The message to encrypt.
             * @param {string} password The password.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {CipherParams} A cipher params object.
             *
             * @static
             *
             * @example
             *
             *     var ciphertextParams = CryptoJS.lib.PasswordBasedCipher.encrypt(CryptoJS.algo.AES, message, 'password');
             *     var ciphertextParams = CryptoJS.lib.PasswordBasedCipher.encrypt(CryptoJS.algo.AES, message, 'password', { format: CryptoJS.format.OpenSSL });
             */
            encrypt: function (cipher, message, password, cfg) {
                // Apply config defaults
                cfg = this.cfg.extend(cfg);

                // Derive key and other params
                var derivedParams = cfg.kdf.execute(password, cipher.keySize, cipher.ivSize);

                // Add IV to config
                cfg.iv = derivedParams.iv;

                // Encrypt
                var ciphertext = SerializableCipher.encrypt.call(this, cipher, message, derivedParams.key, cfg);

                // Mix in derived params
                ciphertext.mixIn(derivedParams);

                return ciphertext;
            },

            /**
             * Decrypts serialized ciphertext using a password.
             *
             * @param {Cipher} cipher The cipher algorithm to use.
             * @param {CipherParams|string} ciphertext The ciphertext to decrypt.
             * @param {string} password The password.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {WordArray} The plaintext.
             *
             * @static
             *
             * @example
             *
             *     var plaintext = CryptoJS.lib.PasswordBasedCipher.decrypt(CryptoJS.algo.AES, formattedCiphertext, 'password', { format: CryptoJS.format.OpenSSL });
             *     var plaintext = CryptoJS.lib.PasswordBasedCipher.decrypt(CryptoJS.algo.AES, ciphertextParams, 'password', { format: CryptoJS.format.OpenSSL });
             */
            decrypt: function (cipher, ciphertext, password, cfg) {
                // Apply config defaults
                cfg = this.cfg.extend(cfg);

                // Convert string to CipherParams
                ciphertext = this._parse(ciphertext, cfg.format);

                // Derive key and other params
                var derivedParams = cfg.kdf.execute(password, cipher.keySize, cipher.ivSize, ciphertext.salt);

                // Add IV to config
                cfg.iv = derivedParams.iv;

                // Decrypt
                var plaintext = SerializableCipher.decrypt.call(this, cipher, ciphertext, derivedParams.key, cfg);

                return plaintext;
            }
        });
    }());


    /**
     * Cipher Feedback block mode.
     */
    CryptoJS.mode.CFB = (function () {
        var CFB = CryptoJS.lib.BlockCipherMode.extend();

        CFB.Encryptor = CFB.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher;
                var blockSize = cipher.blockSize;

                generateKeystreamAndEncrypt.call(this, words, offset, blockSize, cipher);

                // Remember this block to use with next block
                this._prevBlock = words.slice(offset, offset + blockSize);
            }
        });

        CFB.Decryptor = CFB.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher;
                var blockSize = cipher.blockSize;

                // Remember this block to use with next block
                var thisBlock = words.slice(offset, offset + blockSize);

                generateKeystreamAndEncrypt.call(this, words, offset, blockSize, cipher);

                // This block becomes the previous block
                this._prevBlock = thisBlock;
            }
        });

        function generateKeystreamAndEncrypt(words, offset, blockSize, cipher) {
            // Shortcut
            var iv = this._iv;

            // Generate keystream
            if (iv) {
                var keystream = iv.slice(0);

                // Remove IV for subsequent blocks
                this._iv = undefined;
            } else {
                var keystream = this._prevBlock;
            }
            cipher.encryptBlock(keystream, 0);

            // Encrypt
            for (var i = 0; i < blockSize; i++) {
                words[offset + i] ^= keystream[i];
            }
        }

        return CFB;
    }());


    /**
     * Electronic Codebook block mode.
     */
    CryptoJS.mode.ECB = (function () {
        var ECB = CryptoJS.lib.BlockCipherMode.extend();

        ECB.Encryptor = ECB.extend({
            processBlock: function (words, offset) {
                this._cipher.encryptBlock(words, offset);
            }
        });

        ECB.Decryptor = ECB.extend({
            processBlock: function (words, offset) {
                this._cipher.decryptBlock(words, offset);
            }
        });

        return ECB;
    }());


    /**
     * ANSI X.923 padding strategy.
     */
    CryptoJS.pad.AnsiX923 = {
        pad: function (data, blockSize) {
            // Shortcuts
            var dataSigBytes = data.sigBytes;
            var blockSizeBytes = blockSize * 4;

            // Count padding bytes
            var nPaddingBytes = blockSizeBytes - dataSigBytes % blockSizeBytes;

            // Compute last byte position
            var lastBytePos = dataSigBytes + nPaddingBytes - 1;

            // Pad
            data.clamp();
            data.words[lastBytePos >>> 2] |= nPaddingBytes << (24 - (lastBytePos % 4) * 8);
            data.sigBytes += nPaddingBytes;
        },

        unpad: function (data) {
            // Get number of padding bytes from last byte
            var nPaddingBytes = data.words[(data.sigBytes - 1) >>> 2] & 0xff;

            // Remove padding
            data.sigBytes -= nPaddingBytes;
        }
    };


    /**
     * ISO 10126 padding strategy.
     */
    CryptoJS.pad.Iso10126 = {
        pad: function (data, blockSize) {
            // Shortcut
            var blockSizeBytes = blockSize * 4;

            // Count padding bytes
            var nPaddingBytes = blockSizeBytes - data.sigBytes % blockSizeBytes;

            // Pad
            data.concat(CryptoJS.lib.WordArray.random(nPaddingBytes - 1)).
            concat(CryptoJS.lib.WordArray.create([nPaddingBytes << 24], 1));
        },

        unpad: function (data) {
            // Get number of padding bytes from last byte
            var nPaddingBytes = data.words[(data.sigBytes - 1) >>> 2] & 0xff;

            // Remove padding
            data.sigBytes -= nPaddingBytes;
        }
    };


    /**
     * ISO/IEC 9797-1 Padding Method 2.
     */
    CryptoJS.pad.Iso97971 = {
        pad: function (data, blockSize) {
            // Add 0x80 byte
            data.concat(CryptoJS.lib.WordArray.create([0x80000000], 1));

            // Zero pad the rest
            CryptoJS.pad.ZeroPadding.pad(data, blockSize);
        },

        unpad: function (data) {
            // Remove zero padding
            CryptoJS.pad.ZeroPadding.unpad(data);

            // Remove one more byte -- the 0x80 byte
            data.sigBytes--;
        }
    };


    /**
     * Output Feedback block mode.
     */
    CryptoJS.mode.OFB = (function () {
        var OFB = CryptoJS.lib.BlockCipherMode.extend();

        var Encryptor = OFB.Encryptor = OFB.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher
                var blockSize = cipher.blockSize;
                var iv = this._iv;
                var keystream = this._keystream;

                // Generate keystream
                if (iv) {
                    keystream = this._keystream = iv.slice(0);

                    // Remove IV for subsequent blocks
                    this._iv = undefined;
                }
                cipher.encryptBlock(keystream, 0);

                // Encrypt
                for (var i = 0; i < blockSize; i++) {
                    words[offset + i] ^= keystream[i];
                }
            }
        });

        OFB.Decryptor = Encryptor;

        return OFB;
    }());


    /**
     * A noop padding strategy.
     */
    CryptoJS.pad.NoPadding = {
        pad: function () {
        },

        unpad: function () {
        }
    };


    (function (undefined) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var CipherParams = C_lib.CipherParams;
        var C_enc = C.enc;
        var Hex = C_enc.Hex;
        var C_format = C.format;

        var HexFormatter = C_format.Hex = {
            /**
             * Converts the ciphertext of a cipher params object to a hexadecimally encoded string.
             *
             * @param {CipherParams} cipherParams The cipher params object.
             *
             * @return {string} The hexadecimally encoded string.
             *
             * @static
             *
             * @example
             *
             *     var hexString = CryptoJS.format.Hex.stringify(cipherParams);
             */
            stringify: function (cipherParams) {
                return cipherParams.ciphertext.toString(Hex);
            },

            /**
             * Converts a hexadecimally encoded ciphertext string to a cipher params object.
             *
             * @param {string} input The hexadecimally encoded string.
             *
             * @return {CipherParams} The cipher params object.
             *
             * @static
             *
             * @example
             *
             *     var cipherParams = CryptoJS.format.Hex.parse(hexString);
             */
            parse: function (input) {
                var ciphertext = Hex.parse(input);
                return CipherParams.create({ ciphertext: ciphertext });
            }
        };
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var BlockCipher = C_lib.BlockCipher;
        var C_algo = C.algo;

        // Lookup tables
        var SBOX = [];
        var INV_SBOX = [];
        var SUB_MIX_0 = [];
        var SUB_MIX_1 = [];
        var SUB_MIX_2 = [];
        var SUB_MIX_3 = [];
        var INV_SUB_MIX_0 = [];
        var INV_SUB_MIX_1 = [];
        var INV_SUB_MIX_2 = [];
        var INV_SUB_MIX_3 = [];

        // Compute lookup tables
        (function () {
            // Compute double table
            var d = [];
            for (var i = 0; i < 256; i++) {
                if (i < 128) {
                    d[i] = i << 1;
                } else {
                    d[i] = (i << 1) ^ 0x11b;
                }
            }

            // Walk GF(2^8)
            var x = 0;
            var xi = 0;
            for (var i = 0; i < 256; i++) {
                // Compute sbox
                var sx = xi ^ (xi << 1) ^ (xi << 2) ^ (xi << 3) ^ (xi << 4);
                sx = (sx >>> 8) ^ (sx & 0xff) ^ 0x63;
                SBOX[x] = sx;
                INV_SBOX[sx] = x;

                // Compute multiplication
                var x2 = d[x];
                var x4 = d[x2];
                var x8 = d[x4];

                // Compute sub bytes, mix columns tables
                var t = (d[sx] * 0x101) ^ (sx * 0x1010100);
                SUB_MIX_0[x] = (t << 24) | (t >>> 8);
                SUB_MIX_1[x] = (t << 16) | (t >>> 16);
                SUB_MIX_2[x] = (t << 8)  | (t >>> 24);
                SUB_MIX_3[x] = t;

                // Compute inv sub bytes, inv mix columns tables
                var t = (x8 * 0x1010101) ^ (x4 * 0x10001) ^ (x2 * 0x101) ^ (x * 0x1010100);
                INV_SUB_MIX_0[sx] = (t << 24) | (t >>> 8);
                INV_SUB_MIX_1[sx] = (t << 16) | (t >>> 16);
                INV_SUB_MIX_2[sx] = (t << 8)  | (t >>> 24);
                INV_SUB_MIX_3[sx] = t;

                // Compute next counter
                if (!x) {
                    x = xi = 1;
                } else {
                    x = x2 ^ d[d[d[x8 ^ x2]]];
                    xi ^= d[d[xi]];
                }
            }
        }());

        // Precomputed Rcon lookup
        var RCON = [0x00, 0x01, 0x02, 0x04, 0x08, 0x10, 0x20, 0x40, 0x80, 0x1b, 0x36];

        /**
         * AES block cipher algorithm.
         */
        var AES = C_algo.AES = BlockCipher.extend({
            _doReset: function () {
                // Skip reset of nRounds has been set before and key did not change
                if (this._nRounds && this._keyPriorReset === this._key) {
                    return;
                }

                // Shortcuts
                var key = this._keyPriorReset = this._key;
                var keyWords = key.words;
                var keySize = key.sigBytes / 4;

                // Compute number of rounds
                var nRounds = this._nRounds = keySize + 6;

                // Compute number of key schedule rows
                var ksRows = (nRounds + 1) * 4;

                // Compute key schedule
                var keySchedule = this._keySchedule = [];
                for (var ksRow = 0; ksRow < ksRows; ksRow++) {
                    if (ksRow < keySize) {
                        keySchedule[ksRow] = keyWords[ksRow];
                    } else {
                        var t = keySchedule[ksRow - 1];

                        if (!(ksRow % keySize)) {
                            // Rot word
                            t = (t << 8) | (t >>> 24);

                            // Sub word
                            t = (SBOX[t >>> 24] << 24) | (SBOX[(t >>> 16) & 0xff] << 16) | (SBOX[(t >>> 8) & 0xff] << 8) | SBOX[t & 0xff];

                            // Mix Rcon
                            t ^= RCON[(ksRow / keySize) | 0] << 24;
                        } else if (keySize > 6 && ksRow % keySize == 4) {
                            // Sub word
                            t = (SBOX[t >>> 24] << 24) | (SBOX[(t >>> 16) & 0xff] << 16) | (SBOX[(t >>> 8) & 0xff] << 8) | SBOX[t & 0xff];
                        }

                        keySchedule[ksRow] = keySchedule[ksRow - keySize] ^ t;
                    }
                }

                // Compute inv key schedule
                var invKeySchedule = this._invKeySchedule = [];
                for (var invKsRow = 0; invKsRow < ksRows; invKsRow++) {
                    var ksRow = ksRows - invKsRow;

                    if (invKsRow % 4) {
                        var t = keySchedule[ksRow];
                    } else {
                        var t = keySchedule[ksRow - 4];
                    }

                    if (invKsRow < 4 || ksRow <= 4) {
                        invKeySchedule[invKsRow] = t;
                    } else {
                        invKeySchedule[invKsRow] = INV_SUB_MIX_0[SBOX[t >>> 24]] ^ INV_SUB_MIX_1[SBOX[(t >>> 16) & 0xff]] ^
                            INV_SUB_MIX_2[SBOX[(t >>> 8) & 0xff]] ^ INV_SUB_MIX_3[SBOX[t & 0xff]];
                    }
                }
            },

            encryptBlock: function (M, offset) {
                this._doCryptBlock(M, offset, this._keySchedule, SUB_MIX_0, SUB_MIX_1, SUB_MIX_2, SUB_MIX_3, SBOX);
            },

            decryptBlock: function (M, offset) {
                // Swap 2nd and 4th rows
                var t = M[offset + 1];
                M[offset + 1] = M[offset + 3];
                M[offset + 3] = t;

                this._doCryptBlock(M, offset, this._invKeySchedule, INV_SUB_MIX_0, INV_SUB_MIX_1, INV_SUB_MIX_2, INV_SUB_MIX_3, INV_SBOX);

                // Inv swap 2nd and 4th rows
                var t = M[offset + 1];
                M[offset + 1] = M[offset + 3];
                M[offset + 3] = t;
            },

            _doCryptBlock: function (M, offset, keySchedule, SUB_MIX_0, SUB_MIX_1, SUB_MIX_2, SUB_MIX_3, SBOX) {
                // Shortcut
                var nRounds = this._nRounds;

                // Get input, add round key
                var s0 = M[offset]     ^ keySchedule[0];
                var s1 = M[offset + 1] ^ keySchedule[1];
                var s2 = M[offset + 2] ^ keySchedule[2];
                var s3 = M[offset + 3] ^ keySchedule[3];

                // Key schedule row counter
                var ksRow = 4;

                // Rounds
                for (var round = 1; round < nRounds; round++) {
                    // Shift rows, sub bytes, mix columns, add round key
                    var t0 = SUB_MIX_0[s0 >>> 24] ^ SUB_MIX_1[(s1 >>> 16) & 0xff] ^ SUB_MIX_2[(s2 >>> 8) & 0xff] ^ SUB_MIX_3[s3 & 0xff] ^ keySchedule[ksRow++];
                    var t1 = SUB_MIX_0[s1 >>> 24] ^ SUB_MIX_1[(s2 >>> 16) & 0xff] ^ SUB_MIX_2[(s3 >>> 8) & 0xff] ^ SUB_MIX_3[s0 & 0xff] ^ keySchedule[ksRow++];
                    var t2 = SUB_MIX_0[s2 >>> 24] ^ SUB_MIX_1[(s3 >>> 16) & 0xff] ^ SUB_MIX_2[(s0 >>> 8) & 0xff] ^ SUB_MIX_3[s1 & 0xff] ^ keySchedule[ksRow++];
                    var t3 = SUB_MIX_0[s3 >>> 24] ^ SUB_MIX_1[(s0 >>> 16) & 0xff] ^ SUB_MIX_2[(s1 >>> 8) & 0xff] ^ SUB_MIX_3[s2 & 0xff] ^ keySchedule[ksRow++];

                    // Update state
                    s0 = t0;
                    s1 = t1;
                    s2 = t2;
                    s3 = t3;
                }

                // Shift rows, sub bytes, add round key
                var t0 = ((SBOX[s0 >>> 24] << 24) | (SBOX[(s1 >>> 16) & 0xff] << 16) | (SBOX[(s2 >>> 8) & 0xff] << 8) | SBOX[s3 & 0xff]) ^ keySchedule[ksRow++];
                var t1 = ((SBOX[s1 >>> 24] << 24) | (SBOX[(s2 >>> 16) & 0xff] << 16) | (SBOX[(s3 >>> 8) & 0xff] << 8) | SBOX[s0 & 0xff]) ^ keySchedule[ksRow++];
                var t2 = ((SBOX[s2 >>> 24] << 24) | (SBOX[(s3 >>> 16) & 0xff] << 16) | (SBOX[(s0 >>> 8) & 0xff] << 8) | SBOX[s1 & 0xff]) ^ keySchedule[ksRow++];
                var t3 = ((SBOX[s3 >>> 24] << 24) | (SBOX[(s0 >>> 16) & 0xff] << 16) | (SBOX[(s1 >>> 8) & 0xff] << 8) | SBOX[s2 & 0xff]) ^ keySchedule[ksRow++];

                // Set output
                M[offset]     = t0;
                M[offset + 1] = t1;
                M[offset + 2] = t2;
                M[offset + 3] = t3;
            },

            keySize: 256/32
        });

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.AES.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.AES.decrypt(ciphertext, key, cfg);
         */
        C.AES = BlockCipher._createHelper(AES);
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var BlockCipher = C_lib.BlockCipher;
        var C_algo = C.algo;

        // Permuted Choice 1 constants
        var PC1 = [
            57, 49, 41, 33, 25, 17, 9,  1,
            58, 50, 42, 34, 26, 18, 10, 2,
            59, 51, 43, 35, 27, 19, 11, 3,
            60, 52, 44, 36, 63, 55, 47, 39,
            31, 23, 15, 7,  62, 54, 46, 38,
            30, 22, 14, 6,  61, 53, 45, 37,
            29, 21, 13, 5,  28, 20, 12, 4
        ];

        // Permuted Choice 2 constants
        var PC2 = [
            14, 17, 11, 24, 1,  5,
            3,  28, 15, 6,  21, 10,
            23, 19, 12, 4,  26, 8,
            16, 7,  27, 20, 13, 2,
            41, 52, 31, 37, 47, 55,
            30, 40, 51, 45, 33, 48,
            44, 49, 39, 56, 34, 53,
            46, 42, 50, 36, 29, 32
        ];

        // Cumulative bit shift constants
        var BIT_SHIFTS = [1,  2,  4,  6,  8,  10, 12, 14, 15, 17, 19, 21, 23, 25, 27, 28];

        // SBOXes and round permutation constants
        var SBOX_P = [
            {
                0x0: 0x808200,
                0x10000000: 0x8000,
                0x20000000: 0x808002,
                0x30000000: 0x2,
                0x40000000: 0x200,
                0x50000000: 0x808202,
                0x60000000: 0x800202,
                0x70000000: 0x800000,
                0x80000000: 0x202,
                0x90000000: 0x800200,
                0xa0000000: 0x8200,
                0xb0000000: 0x808000,
                0xc0000000: 0x8002,
                0xd0000000: 0x800002,
                0xe0000000: 0x0,
                0xf0000000: 0x8202,
                0x8000000: 0x0,
                0x18000000: 0x808202,
                0x28000000: 0x8202,
                0x38000000: 0x8000,
                0x48000000: 0x808200,
                0x58000000: 0x200,
                0x68000000: 0x808002,
                0x78000000: 0x2,
                0x88000000: 0x800200,
                0x98000000: 0x8200,
                0xa8000000: 0x808000,
                0xb8000000: 0x800202,
                0xc8000000: 0x800002,
                0xd8000000: 0x8002,
                0xe8000000: 0x202,
                0xf8000000: 0x800000,
                0x1: 0x8000,
                0x10000001: 0x2,
                0x20000001: 0x808200,
                0x30000001: 0x800000,
                0x40000001: 0x808002,
                0x50000001: 0x8200,
                0x60000001: 0x200,
                0x70000001: 0x800202,
                0x80000001: 0x808202,
                0x90000001: 0x808000,
                0xa0000001: 0x800002,
                0xb0000001: 0x8202,
                0xc0000001: 0x202,
                0xd0000001: 0x800200,
                0xe0000001: 0x8002,
                0xf0000001: 0x0,
                0x8000001: 0x808202,
                0x18000001: 0x808000,
                0x28000001: 0x800000,
                0x38000001: 0x200,
                0x48000001: 0x8000,
                0x58000001: 0x800002,
                0x68000001: 0x2,
                0x78000001: 0x8202,
                0x88000001: 0x8002,
                0x98000001: 0x800202,
                0xa8000001: 0x202,
                0xb8000001: 0x808200,
                0xc8000001: 0x800200,
                0xd8000001: 0x0,
                0xe8000001: 0x8200,
                0xf8000001: 0x808002
            },
            {
                0x0: 0x40084010,
                0x1000000: 0x4000,
                0x2000000: 0x80000,
                0x3000000: 0x40080010,
                0x4000000: 0x40000010,
                0x5000000: 0x40084000,
                0x6000000: 0x40004000,
                0x7000000: 0x10,
                0x8000000: 0x84000,
                0x9000000: 0x40004010,
                0xa000000: 0x40000000,
                0xb000000: 0x84010,
                0xc000000: 0x80010,
                0xd000000: 0x0,
                0xe000000: 0x4010,
                0xf000000: 0x40080000,
                0x800000: 0x40004000,
                0x1800000: 0x84010,
                0x2800000: 0x10,
                0x3800000: 0x40004010,
                0x4800000: 0x40084010,
                0x5800000: 0x40000000,
                0x6800000: 0x80000,
                0x7800000: 0x40080010,
                0x8800000: 0x80010,
                0x9800000: 0x0,
                0xa800000: 0x4000,
                0xb800000: 0x40080000,
                0xc800000: 0x40000010,
                0xd800000: 0x84000,
                0xe800000: 0x40084000,
                0xf800000: 0x4010,
                0x10000000: 0x0,
                0x11000000: 0x40080010,
                0x12000000: 0x40004010,
                0x13000000: 0x40084000,
                0x14000000: 0x40080000,
                0x15000000: 0x10,
                0x16000000: 0x84010,
                0x17000000: 0x4000,
                0x18000000: 0x4010,
                0x19000000: 0x80000,
                0x1a000000: 0x80010,
                0x1b000000: 0x40000010,
                0x1c000000: 0x84000,
                0x1d000000: 0x40004000,
                0x1e000000: 0x40000000,
                0x1f000000: 0x40084010,
                0x10800000: 0x84010,
                0x11800000: 0x80000,
                0x12800000: 0x40080000,
                0x13800000: 0x4000,
                0x14800000: 0x40004000,
                0x15800000: 0x40084010,
                0x16800000: 0x10,
                0x17800000: 0x40000000,
                0x18800000: 0x40084000,
                0x19800000: 0x40000010,
                0x1a800000: 0x40004010,
                0x1b800000: 0x80010,
                0x1c800000: 0x0,
                0x1d800000: 0x4010,
                0x1e800000: 0x40080010,
                0x1f800000: 0x84000
            },
            {
                0x0: 0x104,
                0x100000: 0x0,
                0x200000: 0x4000100,
                0x300000: 0x10104,
                0x400000: 0x10004,
                0x500000: 0x4000004,
                0x600000: 0x4010104,
                0x700000: 0x4010000,
                0x800000: 0x4000000,
                0x900000: 0x4010100,
                0xa00000: 0x10100,
                0xb00000: 0x4010004,
                0xc00000: 0x4000104,
                0xd00000: 0x10000,
                0xe00000: 0x4,
                0xf00000: 0x100,
                0x80000: 0x4010100,
                0x180000: 0x4010004,
                0x280000: 0x0,
                0x380000: 0x4000100,
                0x480000: 0x4000004,
                0x580000: 0x10000,
                0x680000: 0x10004,
                0x780000: 0x104,
                0x880000: 0x4,
                0x980000: 0x100,
                0xa80000: 0x4010000,
                0xb80000: 0x10104,
                0xc80000: 0x10100,
                0xd80000: 0x4000104,
                0xe80000: 0x4010104,
                0xf80000: 0x4000000,
                0x1000000: 0x4010100,
                0x1100000: 0x10004,
                0x1200000: 0x10000,
                0x1300000: 0x4000100,
                0x1400000: 0x100,
                0x1500000: 0x4010104,
                0x1600000: 0x4000004,
                0x1700000: 0x0,
                0x1800000: 0x4000104,
                0x1900000: 0x4000000,
                0x1a00000: 0x4,
                0x1b00000: 0x10100,
                0x1c00000: 0x4010000,
                0x1d00000: 0x104,
                0x1e00000: 0x10104,
                0x1f00000: 0x4010004,
                0x1080000: 0x4000000,
                0x1180000: 0x104,
                0x1280000: 0x4010100,
                0x1380000: 0x0,
                0x1480000: 0x10004,
                0x1580000: 0x4000100,
                0x1680000: 0x100,
                0x1780000: 0x4010004,
                0x1880000: 0x10000,
                0x1980000: 0x4010104,
                0x1a80000: 0x10104,
                0x1b80000: 0x4000004,
                0x1c80000: 0x4000104,
                0x1d80000: 0x4010000,
                0x1e80000: 0x4,
                0x1f80000: 0x10100
            },
            {
                0x0: 0x80401000,
                0x10000: 0x80001040,
                0x20000: 0x401040,
                0x30000: 0x80400000,
                0x40000: 0x0,
                0x50000: 0x401000,
                0x60000: 0x80000040,
                0x70000: 0x400040,
                0x80000: 0x80000000,
                0x90000: 0x400000,
                0xa0000: 0x40,
                0xb0000: 0x80001000,
                0xc0000: 0x80400040,
                0xd0000: 0x1040,
                0xe0000: 0x1000,
                0xf0000: 0x80401040,
                0x8000: 0x80001040,
                0x18000: 0x40,
                0x28000: 0x80400040,
                0x38000: 0x80001000,
                0x48000: 0x401000,
                0x58000: 0x80401040,
                0x68000: 0x0,
                0x78000: 0x80400000,
                0x88000: 0x1000,
                0x98000: 0x80401000,
                0xa8000: 0x400000,
                0xb8000: 0x1040,
                0xc8000: 0x80000000,
                0xd8000: 0x400040,
                0xe8000: 0x401040,
                0xf8000: 0x80000040,
                0x100000: 0x400040,
                0x110000: 0x401000,
                0x120000: 0x80000040,
                0x130000: 0x0,
                0x140000: 0x1040,
                0x150000: 0x80400040,
                0x160000: 0x80401000,
                0x170000: 0x80001040,
                0x180000: 0x80401040,
                0x190000: 0x80000000,
                0x1a0000: 0x80400000,
                0x1b0000: 0x401040,
                0x1c0000: 0x80001000,
                0x1d0000: 0x400000,
                0x1e0000: 0x40,
                0x1f0000: 0x1000,
                0x108000: 0x80400000,
                0x118000: 0x80401040,
                0x128000: 0x0,
                0x138000: 0x401000,
                0x148000: 0x400040,
                0x158000: 0x80000000,
                0x168000: 0x80001040,
                0x178000: 0x40,
                0x188000: 0x80000040,
                0x198000: 0x1000,
                0x1a8000: 0x80001000,
                0x1b8000: 0x80400040,
                0x1c8000: 0x1040,
                0x1d8000: 0x80401000,
                0x1e8000: 0x400000,
                0x1f8000: 0x401040
            },
            {
                0x0: 0x80,
                0x1000: 0x1040000,
                0x2000: 0x40000,
                0x3000: 0x20000000,
                0x4000: 0x20040080,
                0x5000: 0x1000080,
                0x6000: 0x21000080,
                0x7000: 0x40080,
                0x8000: 0x1000000,
                0x9000: 0x20040000,
                0xa000: 0x20000080,
                0xb000: 0x21040080,
                0xc000: 0x21040000,
                0xd000: 0x0,
                0xe000: 0x1040080,
                0xf000: 0x21000000,
                0x800: 0x1040080,
                0x1800: 0x21000080,
                0x2800: 0x80,
                0x3800: 0x1040000,
                0x4800: 0x40000,
                0x5800: 0x20040080,
                0x6800: 0x21040000,
                0x7800: 0x20000000,
                0x8800: 0x20040000,
                0x9800: 0x0,
                0xa800: 0x21040080,
                0xb800: 0x1000080,
                0xc800: 0x20000080,
                0xd800: 0x21000000,
                0xe800: 0x1000000,
                0xf800: 0x40080,
                0x10000: 0x40000,
                0x11000: 0x80,
                0x12000: 0x20000000,
                0x13000: 0x21000080,
                0x14000: 0x1000080,
                0x15000: 0x21040000,
                0x16000: 0x20040080,
                0x17000: 0x1000000,
                0x18000: 0x21040080,
                0x19000: 0x21000000,
                0x1a000: 0x1040000,
                0x1b000: 0x20040000,
                0x1c000: 0x40080,
                0x1d000: 0x20000080,
                0x1e000: 0x0,
                0x1f000: 0x1040080,
                0x10800: 0x21000080,
                0x11800: 0x1000000,
                0x12800: 0x1040000,
                0x13800: 0x20040080,
                0x14800: 0x20000000,
                0x15800: 0x1040080,
                0x16800: 0x80,
                0x17800: 0x21040000,
                0x18800: 0x40080,
                0x19800: 0x21040080,
                0x1a800: 0x0,
                0x1b800: 0x21000000,
                0x1c800: 0x1000080,
                0x1d800: 0x40000,
                0x1e800: 0x20040000,
                0x1f800: 0x20000080
            },
            {
                0x0: 0x10000008,
                0x100: 0x2000,
                0x200: 0x10200000,
                0x300: 0x10202008,
                0x400: 0x10002000,
                0x500: 0x200000,
                0x600: 0x200008,
                0x700: 0x10000000,
                0x800: 0x0,
                0x900: 0x10002008,
                0xa00: 0x202000,
                0xb00: 0x8,
                0xc00: 0x10200008,
                0xd00: 0x202008,
                0xe00: 0x2008,
                0xf00: 0x10202000,
                0x80: 0x10200000,
                0x180: 0x10202008,
                0x280: 0x8,
                0x380: 0x200000,
                0x480: 0x202008,
                0x580: 0x10000008,
                0x680: 0x10002000,
                0x780: 0x2008,
                0x880: 0x200008,
                0x980: 0x2000,
                0xa80: 0x10002008,
                0xb80: 0x10200008,
                0xc80: 0x0,
                0xd80: 0x10202000,
                0xe80: 0x202000,
                0xf80: 0x10000000,
                0x1000: 0x10002000,
                0x1100: 0x10200008,
                0x1200: 0x10202008,
                0x1300: 0x2008,
                0x1400: 0x200000,
                0x1500: 0x10000000,
                0x1600: 0x10000008,
                0x1700: 0x202000,
                0x1800: 0x202008,
                0x1900: 0x0,
                0x1a00: 0x8,
                0x1b00: 0x10200000,
                0x1c00: 0x2000,
                0x1d00: 0x10002008,
                0x1e00: 0x10202000,
                0x1f00: 0x200008,
                0x1080: 0x8,
                0x1180: 0x202000,
                0x1280: 0x200000,
                0x1380: 0x10000008,
                0x1480: 0x10002000,
                0x1580: 0x2008,
                0x1680: 0x10202008,
                0x1780: 0x10200000,
                0x1880: 0x10202000,
                0x1980: 0x10200008,
                0x1a80: 0x2000,
                0x1b80: 0x202008,
                0x1c80: 0x200008,
                0x1d80: 0x0,
                0x1e80: 0x10000000,
                0x1f80: 0x10002008
            },
            {
                0x0: 0x100000,
                0x10: 0x2000401,
                0x20: 0x400,
                0x30: 0x100401,
                0x40: 0x2100401,
                0x50: 0x0,
                0x60: 0x1,
                0x70: 0x2100001,
                0x80: 0x2000400,
                0x90: 0x100001,
                0xa0: 0x2000001,
                0xb0: 0x2100400,
                0xc0: 0x2100000,
                0xd0: 0x401,
                0xe0: 0x100400,
                0xf0: 0x2000000,
                0x8: 0x2100001,
                0x18: 0x0,
                0x28: 0x2000401,
                0x38: 0x2100400,
                0x48: 0x100000,
                0x58: 0x2000001,
                0x68: 0x2000000,
                0x78: 0x401,
                0x88: 0x100401,
                0x98: 0x2000400,
                0xa8: 0x2100000,
                0xb8: 0x100001,
                0xc8: 0x400,
                0xd8: 0x2100401,
                0xe8: 0x1,
                0xf8: 0x100400,
                0x100: 0x2000000,
                0x110: 0x100000,
                0x120: 0x2000401,
                0x130: 0x2100001,
                0x140: 0x100001,
                0x150: 0x2000400,
                0x160: 0x2100400,
                0x170: 0x100401,
                0x180: 0x401,
                0x190: 0x2100401,
                0x1a0: 0x100400,
                0x1b0: 0x1,
                0x1c0: 0x0,
                0x1d0: 0x2100000,
                0x1e0: 0x2000001,
                0x1f0: 0x400,
                0x108: 0x100400,
                0x118: 0x2000401,
                0x128: 0x2100001,
                0x138: 0x1,
                0x148: 0x2000000,
                0x158: 0x100000,
                0x168: 0x401,
                0x178: 0x2100400,
                0x188: 0x2000001,
                0x198: 0x2100000,
                0x1a8: 0x0,
                0x1b8: 0x2100401,
                0x1c8: 0x100401,
                0x1d8: 0x400,
                0x1e8: 0x2000400,
                0x1f8: 0x100001
            },
            {
                0x0: 0x8000820,
                0x1: 0x20000,
                0x2: 0x8000000,
                0x3: 0x20,
                0x4: 0x20020,
                0x5: 0x8020820,
                0x6: 0x8020800,
                0x7: 0x800,
                0x8: 0x8020000,
                0x9: 0x8000800,
                0xa: 0x20800,
                0xb: 0x8020020,
                0xc: 0x820,
                0xd: 0x0,
                0xe: 0x8000020,
                0xf: 0x20820,
                0x80000000: 0x800,
                0x80000001: 0x8020820,
                0x80000002: 0x8000820,
                0x80000003: 0x8000000,
                0x80000004: 0x8020000,
                0x80000005: 0x20800,
                0x80000006: 0x20820,
                0x80000007: 0x20,
                0x80000008: 0x8000020,
                0x80000009: 0x820,
                0x8000000a: 0x20020,
                0x8000000b: 0x8020800,
                0x8000000c: 0x0,
                0x8000000d: 0x8020020,
                0x8000000e: 0x8000800,
                0x8000000f: 0x20000,
                0x10: 0x20820,
                0x11: 0x8020800,
                0x12: 0x20,
                0x13: 0x800,
                0x14: 0x8000800,
                0x15: 0x8000020,
                0x16: 0x8020020,
                0x17: 0x20000,
                0x18: 0x0,
                0x19: 0x20020,
                0x1a: 0x8020000,
                0x1b: 0x8000820,
                0x1c: 0x8020820,
                0x1d: 0x20800,
                0x1e: 0x820,
                0x1f: 0x8000000,
                0x80000010: 0x20000,
                0x80000011: 0x800,
                0x80000012: 0x8020020,
                0x80000013: 0x20820,
                0x80000014: 0x20,
                0x80000015: 0x8020000,
                0x80000016: 0x8000000,
                0x80000017: 0x8000820,
                0x80000018: 0x8020820,
                0x80000019: 0x8000020,
                0x8000001a: 0x8000800,
                0x8000001b: 0x0,
                0x8000001c: 0x20800,
                0x8000001d: 0x820,
                0x8000001e: 0x20020,
                0x8000001f: 0x8020800
            }
        ];

        // Masks that select the SBOX input
        var SBOX_MASK = [
            0xf8000001, 0x1f800000, 0x01f80000, 0x001f8000,
            0x0001f800, 0x00001f80, 0x000001f8, 0x8000001f
        ];

        /**
         * DES block cipher algorithm.
         */
        var DES = C_algo.DES = BlockCipher.extend({
            _doReset: function () {
                // Shortcuts
                var key = this._key;
                var keyWords = key.words;

                // Select 56 bits according to PC1
                var keyBits = [];
                for (var i = 0; i < 56; i++) {
                    var keyBitPos = PC1[i] - 1;
                    keyBits[i] = (keyWords[keyBitPos >>> 5] >>> (31 - keyBitPos % 32)) & 1;
                }

                // Assemble 16 subkeys
                var subKeys = this._subKeys = [];
                for (var nSubKey = 0; nSubKey < 16; nSubKey++) {
                    // Create subkey
                    var subKey = subKeys[nSubKey] = [];

                    // Shortcut
                    var bitShift = BIT_SHIFTS[nSubKey];

                    // Select 48 bits according to PC2
                    for (var i = 0; i < 24; i++) {
                        // Select from the left 28 key bits
                        subKey[(i / 6) | 0] |= keyBits[((PC2[i] - 1) + bitShift) % 28] << (31 - i % 6);

                        // Select from the right 28 key bits
                        subKey[4 + ((i / 6) | 0)] |= keyBits[28 + (((PC2[i + 24] - 1) + bitShift) % 28)] << (31 - i % 6);
                    }

                    // Since each subkey is applied to an expanded 32-bit input,
                    // the subkey can be broken into 8 values scaled to 32-bits,
                    // which allows the key to be used without expansion
                    subKey[0] = (subKey[0] << 1) | (subKey[0] >>> 31);
                    for (var i = 1; i < 7; i++) {
                        subKey[i] = subKey[i] >>> ((i - 1) * 4 + 3);
                    }
                    subKey[7] = (subKey[7] << 5) | (subKey[7] >>> 27);
                }

                // Compute inverse subkeys
                var invSubKeys = this._invSubKeys = [];
                for (var i = 0; i < 16; i++) {
                    invSubKeys[i] = subKeys[15 - i];
                }
            },

            encryptBlock: function (M, offset) {
                this._doCryptBlock(M, offset, this._subKeys);
            },

            decryptBlock: function (M, offset) {
                this._doCryptBlock(M, offset, this._invSubKeys);
            },

            _doCryptBlock: function (M, offset, subKeys) {
                // Get input
                this._lBlock = M[offset];
                this._rBlock = M[offset + 1];

                // Initial permutation
                exchangeLR.call(this, 4,  0x0f0f0f0f);
                exchangeLR.call(this, 16, 0x0000ffff);
                exchangeRL.call(this, 2,  0x33333333);
                exchangeRL.call(this, 8,  0x00ff00ff);
                exchangeLR.call(this, 1,  0x55555555);

                // Rounds
                for (var round = 0; round < 16; round++) {
                    // Shortcuts
                    var subKey = subKeys[round];
                    var lBlock = this._lBlock;
                    var rBlock = this._rBlock;

                    // Feistel function
                    var f = 0;
                    for (var i = 0; i < 8; i++) {
                        f |= SBOX_P[i][((rBlock ^ subKey[i]) & SBOX_MASK[i]) >>> 0];
                    }
                    this._lBlock = rBlock;
                    this._rBlock = lBlock ^ f;
                }

                // Undo swap from last round
                var t = this._lBlock;
                this._lBlock = this._rBlock;
                this._rBlock = t;

                // Final permutation
                exchangeLR.call(this, 1,  0x55555555);
                exchangeRL.call(this, 8,  0x00ff00ff);
                exchangeRL.call(this, 2,  0x33333333);
                exchangeLR.call(this, 16, 0x0000ffff);
                exchangeLR.call(this, 4,  0x0f0f0f0f);

                // Set output
                M[offset] = this._lBlock;
                M[offset + 1] = this._rBlock;
            },

            keySize: 64/32,

            ivSize: 64/32,

            blockSize: 64/32
        });

        // Swap bits across the left and right words
        function exchangeLR(offset, mask) {
            var t = ((this._lBlock >>> offset) ^ this._rBlock) & mask;
            this._rBlock ^= t;
            this._lBlock ^= t << offset;
        }

        function exchangeRL(offset, mask) {
            var t = ((this._rBlock >>> offset) ^ this._lBlock) & mask;
            this._lBlock ^= t;
            this._rBlock ^= t << offset;
        }

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.DES.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.DES.decrypt(ciphertext, key, cfg);
         */
        C.DES = BlockCipher._createHelper(DES);

        /**
         * Triple-DES block cipher algorithm.
         */
        var TripleDES = C_algo.TripleDES = BlockCipher.extend({
            _doReset: function () {
                // Shortcuts
                var key = this._key;
                var keyWords = key.words;

                // Create DES instances
                this._des1 = DES.createEncryptor(WordArray.create(keyWords.slice(0, 2)));
                this._des2 = DES.createEncryptor(WordArray.create(keyWords.slice(2, 4)));
                this._des3 = DES.createEncryptor(WordArray.create(keyWords.slice(4, 6)));
            },

            encryptBlock: function (M, offset) {
                this._des1.encryptBlock(M, offset);
                this._des2.decryptBlock(M, offset);
                this._des3.encryptBlock(M, offset);
            },

            decryptBlock: function (M, offset) {
                this._des3.decryptBlock(M, offset);
                this._des2.encryptBlock(M, offset);
                this._des1.decryptBlock(M, offset);
            },

            keySize: 192/32,

            ivSize: 64/32,

            blockSize: 64/32
        });

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.TripleDES.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.TripleDES.decrypt(ciphertext, key, cfg);
         */
        C.TripleDES = BlockCipher._createHelper(TripleDES);
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var StreamCipher = C_lib.StreamCipher;
        var C_algo = C.algo;

        /**
         * RC4 stream cipher algorithm.
         */
        var RC4 = C_algo.RC4 = StreamCipher.extend({
            _doReset: function () {
                // Shortcuts
                var key = this._key;
                var keyWords = key.words;
                var keySigBytes = key.sigBytes;

                // Init sbox
                var S = this._S = [];
                for (var i = 0; i < 256; i++) {
                    S[i] = i;
                }

                // Key setup
                for (var i = 0, j = 0; i < 256; i++) {
                    var keyByteIndex = i % keySigBytes;
                    var keyByte = (keyWords[keyByteIndex >>> 2] >>> (24 - (keyByteIndex % 4) * 8)) & 0xff;

                    j = (j + S[i] + keyByte) % 256;

                    // Swap
                    var t = S[i];
                    S[i] = S[j];
                    S[j] = t;
                }

                // Counters
                this._i = this._j = 0;
            },

            _doProcessBlock: function (M, offset) {
                M[offset] ^= generateKeystreamWord.call(this);
            },

            keySize: 256/32,

            ivSize: 0
        });

        function generateKeystreamWord() {
            // Shortcuts
            var S = this._S;
            var i = this._i;
            var j = this._j;

            // Generate keystream word
            var keystreamWord = 0;
            for (var n = 0; n < 4; n++) {
                i = (i + 1) % 256;
                j = (j + S[i]) % 256;

                // Swap
                var t = S[i];
                S[i] = S[j];
                S[j] = t;

                keystreamWord |= S[(S[i] + S[j]) % 256] << (24 - n * 8);
            }

            // Update counters
            this._i = i;
            this._j = j;

            return keystreamWord;
        }

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.RC4.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.RC4.decrypt(ciphertext, key, cfg);
         */
        C.RC4 = StreamCipher._createHelper(RC4);

        /**
         * Modified RC4 stream cipher algorithm.
         */
        var RC4Drop = C_algo.RC4Drop = RC4.extend({
            /**
             * Configuration options.
             *
             * @property {number} drop The number of keystream words to drop. Default 192
             */
            cfg: RC4.cfg.extend({
                drop: 192
            }),

            _doReset: function () {
                RC4._doReset.call(this);

                // Drop
                for (var i = this.cfg.drop; i > 0; i--) {
                    generateKeystreamWord.call(this);
                }
            }
        });

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.RC4Drop.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.RC4Drop.decrypt(ciphertext, key, cfg);
         */
        C.RC4Drop = StreamCipher._createHelper(RC4Drop);
    }());


    /** @preserve
     * Counter block mode compatible with  Dr Brian Gladman fileenc.c
     * derived from CryptoJS.mode.CTR
     * Jan Hruby jhruby.web@gmail.com
     */
    CryptoJS.mode.CTRGladman = (function () {
        var CTRGladman = CryptoJS.lib.BlockCipherMode.extend();

        function incWord(word)
        {
            if (((word >> 24) & 0xff) === 0xff) { //overflow
                var b1 = (word >> 16)&0xff;
                var b2 = (word >> 8)&0xff;
                var b3 = word & 0xff;

                if (b1 === 0xff) // overflow b1
                {
                    b1 = 0;
                    if (b2 === 0xff)
                    {
                        b2 = 0;
                        if (b3 === 0xff)
                        {
                            b3 = 0;
                        }
                        else
                        {
                            ++b3;
                        }
                    }
                    else
                    {
                        ++b2;
                    }
                }
                else
                {
                    ++b1;
                }

                word = 0;
                word += (b1 << 16);
                word += (b2 << 8);
                word += b3;
            }
            else
            {
                word += (0x01 << 24);
            }
            return word;
        }

        function incCounter(counter)
        {
            if ((counter[0] = incWord(counter[0])) === 0)
            {
                // encr_data in fileenc.c from  Dr Brian Gladman's counts only with DWORD j < 8
                counter[1] = incWord(counter[1]);
            }
            return counter;
        }

        var Encryptor = CTRGladman.Encryptor = CTRGladman.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher
                var blockSize = cipher.blockSize;
                var iv = this._iv;
                var counter = this._counter;

                // Generate keystream
                if (iv) {
                    counter = this._counter = iv.slice(0);

                    // Remove IV for subsequent blocks
                    this._iv = undefined;
                }

                incCounter(counter);

                var keystream = counter.slice(0);
                cipher.encryptBlock(keystream, 0);

                // Encrypt
                for (var i = 0; i < blockSize; i++) {
                    words[offset + i] ^= keystream[i];
                }
            }
        });

        CTRGladman.Decryptor = Encryptor;

        return CTRGladman;
    }());




    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var StreamCipher = C_lib.StreamCipher;
        var C_algo = C.algo;

        // Reusable objects
        var S  = [];
        var C_ = [];
        var G  = [];

        /**
         * Rabbit stream cipher algorithm
         */
        var Rabbit = C_algo.Rabbit = StreamCipher.extend({
            _doReset: function () {
                // Shortcuts
                var K = this._key.words;
                var iv = this.cfg.iv;

                // Swap endian
                for (var i = 0; i < 4; i++) {
                    K[i] = (((K[i] << 8)  | (K[i] >>> 24)) & 0x00ff00ff) |
                        (((K[i] << 24) | (K[i] >>> 8))  & 0xff00ff00);
                }

                // Generate initial state values
                var X = this._X = [
                    K[0], (K[3] << 16) | (K[2] >>> 16),
                    K[1], (K[0] << 16) | (K[3] >>> 16),
                    K[2], (K[1] << 16) | (K[0] >>> 16),
                    K[3], (K[2] << 16) | (K[1] >>> 16)
                ];

                // Generate initial counter values
                var C = this._C = [
                    (K[2] << 16) | (K[2] >>> 16), (K[0] & 0xffff0000) | (K[1] & 0x0000ffff),
                    (K[3] << 16) | (K[3] >>> 16), (K[1] & 0xffff0000) | (K[2] & 0x0000ffff),
                    (K[0] << 16) | (K[0] >>> 16), (K[2] & 0xffff0000) | (K[3] & 0x0000ffff),
                    (K[1] << 16) | (K[1] >>> 16), (K[3] & 0xffff0000) | (K[0] & 0x0000ffff)
                ];

                // Carry bit
                this._b = 0;

                // Iterate the system four times
                for (var i = 0; i < 4; i++) {
                    nextState.call(this);
                }

                // Modify the counters
                for (var i = 0; i < 8; i++) {
                    C[i] ^= X[(i + 4) & 7];
                }

                // IV setup
                if (iv) {
                    // Shortcuts
                    var IV = iv.words;
                    var IV_0 = IV[0];
                    var IV_1 = IV[1];

                    // Generate four subvectors
                    var i0 = (((IV_0 << 8) | (IV_0 >>> 24)) & 0x00ff00ff) | (((IV_0 << 24) | (IV_0 >>> 8)) & 0xff00ff00);
                    var i2 = (((IV_1 << 8) | (IV_1 >>> 24)) & 0x00ff00ff) | (((IV_1 << 24) | (IV_1 >>> 8)) & 0xff00ff00);
                    var i1 = (i0 >>> 16) | (i2 & 0xffff0000);
                    var i3 = (i2 << 16)  | (i0 & 0x0000ffff);

                    // Modify counter values
                    C[0] ^= i0;
                    C[1] ^= i1;
                    C[2] ^= i2;
                    C[3] ^= i3;
                    C[4] ^= i0;
                    C[5] ^= i1;
                    C[6] ^= i2;
                    C[7] ^= i3;

                    // Iterate the system four times
                    for (var i = 0; i < 4; i++) {
                        nextState.call(this);
                    }
                }
            },

            _doProcessBlock: function (M, offset) {
                // Shortcut
                var X = this._X;

                // Iterate the system
                nextState.call(this);

                // Generate four keystream words
                S[0] = X[0] ^ (X[5] >>> 16) ^ (X[3] << 16);
                S[1] = X[2] ^ (X[7] >>> 16) ^ (X[5] << 16);
                S[2] = X[4] ^ (X[1] >>> 16) ^ (X[7] << 16);
                S[3] = X[6] ^ (X[3] >>> 16) ^ (X[1] << 16);

                for (var i = 0; i < 4; i++) {
                    // Swap endian
                    S[i] = (((S[i] << 8)  | (S[i] >>> 24)) & 0x00ff00ff) |
                        (((S[i] << 24) | (S[i] >>> 8))  & 0xff00ff00);

                    // Encrypt
                    M[offset + i] ^= S[i];
                }
            },

            blockSize: 128/32,

            ivSize: 64/32
        });

        function nextState() {
            // Shortcuts
            var X = this._X;
            var C = this._C;

            // Save old counter values
            for (var i = 0; i < 8; i++) {
                C_[i] = C[i];
            }

            // Calculate new counter values
            C[0] = (C[0] + 0x4d34d34d + this._b) | 0;
            C[1] = (C[1] + 0xd34d34d3 + ((C[0] >>> 0) < (C_[0] >>> 0) ? 1 : 0)) | 0;
            C[2] = (C[2] + 0x34d34d34 + ((C[1] >>> 0) < (C_[1] >>> 0) ? 1 : 0)) | 0;
            C[3] = (C[3] + 0x4d34d34d + ((C[2] >>> 0) < (C_[2] >>> 0) ? 1 : 0)) | 0;
            C[4] = (C[4] + 0xd34d34d3 + ((C[3] >>> 0) < (C_[3] >>> 0) ? 1 : 0)) | 0;
            C[5] = (C[5] + 0x34d34d34 + ((C[4] >>> 0) < (C_[4] >>> 0) ? 1 : 0)) | 0;
            C[6] = (C[6] + 0x4d34d34d + ((C[5] >>> 0) < (C_[5] >>> 0) ? 1 : 0)) | 0;
            C[7] = (C[7] + 0xd34d34d3 + ((C[6] >>> 0) < (C_[6] >>> 0) ? 1 : 0)) | 0;
            this._b = (C[7] >>> 0) < (C_[7] >>> 0) ? 1 : 0;

            // Calculate the g-values
            for (var i = 0; i < 8; i++) {
                var gx = X[i] + C[i];

                // Construct high and low argument for squaring
                var ga = gx & 0xffff;
                var gb = gx >>> 16;

                // Calculate high and low result of squaring
                var gh = ((((ga * ga) >>> 17) + ga * gb) >>> 15) + gb * gb;
                var gl = (((gx & 0xffff0000) * gx) | 0) + (((gx & 0x0000ffff) * gx) | 0);

                // High XOR low
                G[i] = gh ^ gl;
            }

            // Calculate new state values
            X[0] = (G[0] + ((G[7] << 16) | (G[7] >>> 16)) + ((G[6] << 16) | (G[6] >>> 16))) | 0;
            X[1] = (G[1] + ((G[0] << 8)  | (G[0] >>> 24)) + G[7]) | 0;
            X[2] = (G[2] + ((G[1] << 16) | (G[1] >>> 16)) + ((G[0] << 16) | (G[0] >>> 16))) | 0;
            X[3] = (G[3] + ((G[2] << 8)  | (G[2] >>> 24)) + G[1]) | 0;
            X[4] = (G[4] + ((G[3] << 16) | (G[3] >>> 16)) + ((G[2] << 16) | (G[2] >>> 16))) | 0;
            X[5] = (G[5] + ((G[4] << 8)  | (G[4] >>> 24)) + G[3]) | 0;
            X[6] = (G[6] + ((G[5] << 16) | (G[5] >>> 16)) + ((G[4] << 16) | (G[4] >>> 16))) | 0;
            X[7] = (G[7] + ((G[6] << 8)  | (G[6] >>> 24)) + G[5]) | 0;
        }

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.Rabbit.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.Rabbit.decrypt(ciphertext, key, cfg);
         */
        C.Rabbit = StreamCipher._createHelper(Rabbit);
    }());


    /**
     * Counter block mode.
     */
    CryptoJS.mode.CTR = (function () {
        var CTR = CryptoJS.lib.BlockCipherMode.extend();

        var Encryptor = CTR.Encryptor = CTR.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher
                var blockSize = cipher.blockSize;
                var iv = this._iv;
                var counter = this._counter;

                // Generate keystream
                if (iv) {
                    counter = this._counter = iv.slice(0);

                    // Remove IV for subsequent blocks
                    this._iv = undefined;
                }
                var keystream = counter.slice(0);
                cipher.encryptBlock(keystream, 0);

                // Increment counter
                counter[blockSize - 1] = (counter[blockSize - 1] + 1) | 0

                // Encrypt
                for (var i = 0; i < blockSize; i++) {
                    words[offset + i] ^= keystream[i];
                }
            }
        });

        CTR.Decryptor = Encryptor;

        return CTR;
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var StreamCipher = C_lib.StreamCipher;
        var C_algo = C.algo;

        // Reusable objects
        var S  = [];
        var C_ = [];
        var G  = [];

        /**
         * Rabbit stream cipher algorithm.
         *
         * This is a legacy version that neglected to convert the key to little-endian.
         * This error doesn't affect the cipher's security,
         * but it does affect its compatibility with other implementations.
         */
        var RabbitLegacy = C_algo.RabbitLegacy = StreamCipher.extend({
            _doReset: function () {
                // Shortcuts
                var K = this._key.words;
                var iv = this.cfg.iv;

                // Generate initial state values
                var X = this._X = [
                    K[0], (K[3] << 16) | (K[2] >>> 16),
                    K[1], (K[0] << 16) | (K[3] >>> 16),
                    K[2], (K[1] << 16) | (K[0] >>> 16),
                    K[3], (K[2] << 16) | (K[1] >>> 16)
                ];

                // Generate initial counter values
                var C = this._C = [
                    (K[2] << 16) | (K[2] >>> 16), (K[0] & 0xffff0000) | (K[1] & 0x0000ffff),
                    (K[3] << 16) | (K[3] >>> 16), (K[1] & 0xffff0000) | (K[2] & 0x0000ffff),
                    (K[0] << 16) | (K[0] >>> 16), (K[2] & 0xffff0000) | (K[3] & 0x0000ffff),
                    (K[1] << 16) | (K[1] >>> 16), (K[3] & 0xffff0000) | (K[0] & 0x0000ffff)
                ];

                // Carry bit
                this._b = 0;

                // Iterate the system four times
                for (var i = 0; i < 4; i++) {
                    nextState.call(this);
                }

                // Modify the counters
                for (var i = 0; i < 8; i++) {
                    C[i] ^= X[(i + 4) & 7];
                }

                // IV setup
                if (iv) {
                    // Shortcuts
                    var IV = iv.words;
                    var IV_0 = IV[0];
                    var IV_1 = IV[1];

                    // Generate four subvectors
                    var i0 = (((IV_0 << 8) | (IV_0 >>> 24)) & 0x00ff00ff) | (((IV_0 << 24) | (IV_0 >>> 8)) & 0xff00ff00);
                    var i2 = (((IV_1 << 8) | (IV_1 >>> 24)) & 0x00ff00ff) | (((IV_1 << 24) | (IV_1 >>> 8)) & 0xff00ff00);
                    var i1 = (i0 >>> 16) | (i2 & 0xffff0000);
                    var i3 = (i2 << 16)  | (i0 & 0x0000ffff);

                    // Modify counter values
                    C[0] ^= i0;
                    C[1] ^= i1;
                    C[2] ^= i2;
                    C[3] ^= i3;
                    C[4] ^= i0;
                    C[5] ^= i1;
                    C[6] ^= i2;
                    C[7] ^= i3;

                    // Iterate the system four times
                    for (var i = 0; i < 4; i++) {
                        nextState.call(this);
                    }
                }
            },

            _doProcessBlock: function (M, offset) {
                // Shortcut
                var X = this._X;

                // Iterate the system
                nextState.call(this);

                // Generate four keystream words
                S[0] = X[0] ^ (X[5] >>> 16) ^ (X[3] << 16);
                S[1] = X[2] ^ (X[7] >>> 16) ^ (X[5] << 16);
                S[2] = X[4] ^ (X[1] >>> 16) ^ (X[7] << 16);
                S[3] = X[6] ^ (X[3] >>> 16) ^ (X[1] << 16);

                for (var i = 0; i < 4; i++) {
                    // Swap endian
                    S[i] = (((S[i] << 8)  | (S[i] >>> 24)) & 0x00ff00ff) |
                        (((S[i] << 24) | (S[i] >>> 8))  & 0xff00ff00);

                    // Encrypt
                    M[offset + i] ^= S[i];
                }
            },

            blockSize: 128/32,

            ivSize: 64/32
        });

        function nextState() {
            // Shortcuts
            var X = this._X;
            var C = this._C;

            // Save old counter values
            for (var i = 0; i < 8; i++) {
                C_[i] = C[i];
            }

            // Calculate new counter values
            C[0] = (C[0] + 0x4d34d34d + this._b) | 0;
            C[1] = (C[1] + 0xd34d34d3 + ((C[0] >>> 0) < (C_[0] >>> 0) ? 1 : 0)) | 0;
            C[2] = (C[2] + 0x34d34d34 + ((C[1] >>> 0) < (C_[1] >>> 0) ? 1 : 0)) | 0;
            C[3] = (C[3] + 0x4d34d34d + ((C[2] >>> 0) < (C_[2] >>> 0) ? 1 : 0)) | 0;
            C[4] = (C[4] + 0xd34d34d3 + ((C[3] >>> 0) < (C_[3] >>> 0) ? 1 : 0)) | 0;
            C[5] = (C[5] + 0x34d34d34 + ((C[4] >>> 0) < (C_[4] >>> 0) ? 1 : 0)) | 0;
            C[6] = (C[6] + 0x4d34d34d + ((C[5] >>> 0) < (C_[5] >>> 0) ? 1 : 0)) | 0;
            C[7] = (C[7] + 0xd34d34d3 + ((C[6] >>> 0) < (C_[6] >>> 0) ? 1 : 0)) | 0;
            this._b = (C[7] >>> 0) < (C_[7] >>> 0) ? 1 : 0;

            // Calculate the g-values
            for (var i = 0; i < 8; i++) {
                var gx = X[i] + C[i];

                // Construct high and low argument for squaring
                var ga = gx & 0xffff;
                var gb = gx >>> 16;

                // Calculate high and low result of squaring
                var gh = ((((ga * ga) >>> 17) + ga * gb) >>> 15) + gb * gb;
                var gl = (((gx & 0xffff0000) * gx) | 0) + (((gx & 0x0000ffff) * gx) | 0);

                // High XOR low
                G[i] = gh ^ gl;
            }

            // Calculate new state values
            X[0] = (G[0] + ((G[7] << 16) | (G[7] >>> 16)) + ((G[6] << 16) | (G[6] >>> 16))) | 0;
            X[1] = (G[1] + ((G[0] << 8)  | (G[0] >>> 24)) + G[7]) | 0;
            X[2] = (G[2] + ((G[1] << 16) | (G[1] >>> 16)) + ((G[0] << 16) | (G[0] >>> 16))) | 0;
            X[3] = (G[3] + ((G[2] << 8)  | (G[2] >>> 24)) + G[1]) | 0;
            X[4] = (G[4] + ((G[3] << 16) | (G[3] >>> 16)) + ((G[2] << 16) | (G[2] >>> 16))) | 0;
            X[5] = (G[5] + ((G[4] << 8)  | (G[4] >>> 24)) + G[3]) | 0;
            X[6] = (G[6] + ((G[5] << 16) | (G[5] >>> 16)) + ((G[4] << 16) | (G[4] >>> 16))) | 0;
            X[7] = (G[7] + ((G[6] << 8)  | (G[6] >>> 24)) + G[5]) | 0;
        }

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.RabbitLegacy.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.RabbitLegacy.decrypt(ciphertext, key, cfg);
         */
        C.RabbitLegacy = StreamCipher._createHelper(RabbitLegacy);
    }());


    /**
     * Zero padding strategy.
     */
    CryptoJS.pad.ZeroPadding = {
        pad: function (data, blockSize) {
            // Shortcut
            var blockSizeBytes = blockSize * 4;

            // Pad
            data.clamp();
            data.sigBytes += blockSizeBytes - ((data.sigBytes % blockSizeBytes) || blockSizeBytes);
        },

        unpad: function (data) {
            // Shortcut
            var dataWords = data.words;

            // Unpad
            var i = data.sigBytes - 1;
            while (!((dataWords[i >>> 2] >>> (24 - (i % 4) * 8)) & 0xff)) {
                i--;
            }
            data.sigBytes = i + 1;
        }
    };


    return CryptoJS;

}));</script>

<script>
    // variables to be filled when generating the file
    var encryptedMsg = '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',
        salt = 'b9acd7716e45272ac2da1492570f3b9a',
        isRememberEnabled = true,
        rememberDurationInDays = 1; // 0 means forever

    // constants
    var rememberPassphraseKey = 'staticrypt_passphrase',
        rememberExpirationKey = 'staticrypt_expiration';

    /**
     * Decrypt a salted msg using a password.
     * Inspired by https://github.com/adonespitogo
     *
     * @param  encryptedMsg
     * @param  hashedPassphrase
     * @returns 
     */
    function decryptMsg(encryptedMsg, hashedPassphrase) {
        var iv = CryptoJS.enc.Hex.parse(encryptedMsg.substr(0, 32))
        var encrypted = encryptedMsg.substring(32);

        return CryptoJS.AES.decrypt(encrypted, hashedPassphrase, {
            iv: iv,
            padding: CryptoJS.pad.Pkcs7,
            mode: CryptoJS.mode.CBC
        }).toString(CryptoJS.enc.Utf8);
    }

    /**
     * Decrypt our encrypted page, replace the whole HTML.
     *
     * @param  hashedPassphrase
     * @returns 
     */
    function decryptAndReplaceHtml(hashedPassphrase) {
        var encryptedHMAC = encryptedMsg.substring(0, 64),
            encryptedHTML = encryptedMsg.substring(64),
            decryptedHMAC = CryptoJS.HmacSHA256(encryptedHTML, CryptoJS.SHA256(hashedPassphrase).toString()).toString();

        if (decryptedHMAC !== encryptedHMAC) {
            return false;
        }

        var plainHTML = decryptMsg(encryptedHTML, hashedPassphrase);

        document.write(plainHTML);
        document.close();

        return true;
    }

    /**
     * Salt and hash the passphrase so it can be stored in localStorage without opening a password reuse vulnerability.
     *
     * @param  passphrase
     * @returns 
     */
    function hashPassphrase(passphrase) {
        return CryptoJS.PBKDF2(passphrase, salt, {
            keySize: 256 / 32,
            iterations: 1000
        }).toString();
    }

    /**
     * Clear localstorage from staticrypt related values
     */
    function clearLocalStorage() {
        localStorage.removeItem(rememberPassphraseKey);
        localStorage.removeItem(rememberExpirationKey);
    }

    // try to automatically decrypt on load if there is a saved password
    window.onload = function () {
        if (isRememberEnabled) {
            // show the remember me checkbox
            document.getElementById('staticrypt-remember-label').classList.remove('hidden');

            // if we are login out, clear the storage and terminate
            var queryParams = new URLSearchParams(window.location.search);

            if (queryParams.has("staticrypt_logout")) {
                return clearLocalStorage();
            }

            // if there is expiration configured, check if we're not beyond the expiration
            if (rememberDurationInDays && rememberDurationInDays > 0) {
                var expiration = localStorage.getItem(rememberExpirationKey),
                    isExpired = expiration && new Date().getTime() > parseInt(expiration);

                if (isExpired) {
                    return clearLocalStorage();
                }
            }

            var hashedPassphrase = localStorage.getItem(rememberPassphraseKey);

            if (hashedPassphrase) {
                // try to decrypt
                var isDecryptionSuccessful = decryptAndReplaceHtml(hashedPassphrase);

                // if the decryption is unsuccessful the password might be wrong - silently clear the saved data and let
                // the user fill the password form again
                if (!isDecryptionSuccessful) {
                    return clearLocalStorage();
                }
            }
        }
    }

    // handle password form submission
    document.getElementById('staticrypt-form').addEventListener('submit', function (e) {
        e.preventDefault();

        var passphrase = document.getElementById('staticrypt-password').value,
            shouldRememberPassphrase = document.getElementById('staticrypt-remember').checked;

        // decrypt and replace the whole page
        var hashedPassphrase = hashPassphrase(passphrase);
        var isDecryptionSuccessful = decryptAndReplaceHtml(hashedPassphrase);

        if (isDecryptionSuccessful) {
            // remember the hashedPassphrase and set its expiration if necessary
            if (isRememberEnabled && shouldRememberPassphrase) {
                window.localStorage.setItem(rememberPassphraseKey, hashedPassphrase);

                // set the expiration if the duration isn't 0 (meaning no expiration)
                if (rememberDurationInDays > 0) {
                    window.localStorage.setItem(
                        rememberExpirationKey,
                        (new Date().getTime() + rememberDurationInDays * 24 * 60 * 60 * 1000).toString()
                    );
                }
            }
        } else {
            alert('Bad passphrase!');
        }
    });
</script>
</body>
</html>
