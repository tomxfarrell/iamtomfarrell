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
        salt = '455cd33ed4325bffc42a53004b06bf34',
        isRememberEnabled = true,
        rememberDurationInDays = 0; // 0 means forever

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
